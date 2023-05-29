<?php

    class EmployeeRequirementRespondentModel extends Model
    {
        public $table = 'employee_requirement_respondents';
        public $_fillables = [
            'eerr_reference',
            'cert_id',
            'user_id',
            'eerr_title',
            'eerr_description',
            'eerr_status',
            'date_of_entry',
            'approved_by',
            'approved_date'
        ];

        public function create($eeRequirementRespondentData) {
            $_fillables = parent::getFillablesOnly($eeRequirementRespondentData);
            $_fillables['eerr_reference'] = $this->token->createMix();
            $_fillables['eerr_status'] = 'pending';
            $_fillables['date_of_entry'] = now();
            return parent::store($_fillables);
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER {$params['order']}";
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT {$params['limit']}";
            }

            $this->db->query(
                "SELECT eerr.*, er.*, eerr.id as id ,
                    concat(user.first_name , ' ',user.last_name) as full_name,
                    concat(approver.first_name , ' ',approver.last_name) as approver_name,
                    
                    position.attr_name as position_name,
                    position.attr_abbr_name as position_abbr_name

                    FROM {$this->table} as eerr
                    LEFT JOIN employee_requirements as er
                    ON eerr.cert_id = er.id
                    
                    LEFT JOIN users as user
                    ON user.id = eerr.user_id

                    LEFT JOIN users as approver
                    ON approver.id = eerr.approved_by

                    LEFT JOIN employment_details as ed 
                    ON ed.user_id = user.id

                    LEFT JOIN employment_attributes as position
                    on position.id = ed.position_id
                    
                    {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }

        public function get($id) {
            return $this->getAll([
                'where' => [
                    'eerr.id' => $id
                ]
            ])[0] ?? false;
        }

        public function approve($id) {
            return parent::update([
                'eerr_status' => 'approved',
                'approved_by' => whoIs('id'),
                'approved_date' => now()
            ], $id);
        }
    }