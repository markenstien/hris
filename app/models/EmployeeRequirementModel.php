<?php 

    class EmployeeRequirementModel extends Model
    {
        public $table = 'employee_requirements';
        public $table_recipients = 'employee_requirements_recipients';
        

        private $eeAttributeModel;

        public $_fillables = [
            'req_title',
            'importance',
            'start_date',
            'end_date',
            'description'
        ];

        public function __construct()
        {
            parent::__construct();
        }

        public function create($requirementData) 
        {
            $isAllDepartment = !empty($requirementData['department_select_all']);
            $isAllPosition   = !empty($requirementData['position_select_all']);
            
            $_fillables = parent::getFillablesOnly($requirementData);
            $_fillables['req_code'] = $this->token->createMix();
            $_fillables['is_all_department'] = $isAllDepartment;
            $_fillables['is_all_position'] = $isAllPosition;

            $requirementId = parent::store($_fillables);

            if(!$isAllDepartment) {
                $this->dbHelper->insert(...[
                    $this->table_recipients,
                    [
                        'employee_requirement_id' => $requirementId,
                        'err_category' => 'department',
                        'err_id' =>  json_encode($requirementData['departments'])
                    ]
                ]);
            }

            if(!$isAllPosition) {
                $this->dbHelper->insert(...[
                    $this->table_recipients,
                    [
                        'employee_requirement_id' => $requirementId,
                        'err_category' => 'position',
                        'err_id' =>  json_encode($requirementData['positions'])
                    ]
                ]);
            }

            return $requirementId;
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY {$params['order']} ";
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT {$params['limit']}";
            }

            $this->db->query(
                "SELECT * FROM {$this->table}
                {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }

        public function get($id) {
            $requirement = $this->getAll([
                'where' => [
                    'id' => $id
                ]
            ])[0] ?? false;

            if($requirement) {
                return $this->_appenRecipient($requirement);
            } else {
                return false;
            }
        }

        private function _appenRecipient($training) {

            $recipients =  $this->dbHelper->resultSet($this->table_recipients, '*', parent::conditionConvert([
                'employee_requirement_id' => $training->id
            ]));

            $departmentIds = [];
            $positionIds = [];

            if($recipients) {
                foreach($recipients as $key => $row) {
                    $ids = json_decode($row->err_id);
                    if($ids) {
                        switch($row->err_category) {
                            case 'department':
                                $departmentIds = $ids;
                                break;
                            break;
                            case 'position':
                                $positionIds = $ids;
                                break;
                            break;
                        }
                    }
                }
            }

            if(!empty($departmentIds) || !empty($positionIds)) {
                if(!isset($this->eeAttributeModel)) {
                    $this->eeAttributeModel = model('EmploymentAttributeModel');
                }
                $mergeIds = array_merge($departmentIds, $positionIds);
                $training->recipients = $this->eeAttributeModel->getAll([
                    'where' => [
                        'ea.id' => [
                            'condition' => 'in',
                            'value' => $mergeIds
                        ]
                    ]
                ]);
            }
            return $training;
        }
        
    }