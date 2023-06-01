<?php 

    class LeaveModel extends Model
    {
        public $table = 'employment_leaves';
        private $leavePointModel;

        public $_fillables = [
            'user_id',
            'date_filed',
            'start_date',
            'end_date',
            'status',
            'leave_category',
            'reason',
            'remarks'
        ];

        public function __construct()
        {
            parent::__construct();
            if(!isset($this->leavePointModel)) {
                $this->leavePointModel = model('LeavePointModel');
            }
        }

        public function add($leaveData) {
            $_fillables = parent::getFillablesOnly($leaveData);
            $isValid = $this->_validateLeaveEntry($_fillables);
            
            if(!$isValid)
                return false;

            if($this->_isMultipleDates($_fillables['start_date'], $_fillables['end_date'])) {
                return $this->_multipleDate($_fillables);
            } else {
                return $this->_addEntry($_fillables);
            }
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = ' WHERE '.parent::conditionConvert($params['where']);
            }

            if(!empty($params['order'])) {
                $order = ' ORDER BY '.$params['order'];
            }

            if(!empty($params['limit'])) {
                $limit = ' LIMIT ' . $params['limit'];
            }

            $this->db->query(
                "SELECT el.*, 
                    concat(user.first_name, ' ' ,user.last_name) as user_full_name,ee.reports_to as reports_to,
                    ifnull(concat(approver.first_name, ' ', approver.last_name), 'Not yet approved') as approver_full_name
                    
                    FROM {$this->table} as el
                    
                    LEFT JOIN users as user
                    on el.user_id = user.id

                    LEFT JOIN employment_details as ee
                    on ee.user_id = el.user_id

                    LEFT JOIN users as approver
                    on approver.id = el.approved_by
                    {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }

        public function get($id) {
            return $this->getAll([
                'where' => [
                    'el.id' => $id
                ]
            ])[0] ?? false;
        }

        public function approve($id) {
            return parent::update([
                'approval_date' => today(),
                'approved_by' => whoIs('id'),
                'status' => 'approved'
            ], $id);
        }

        public function update($leaveData, $id) {
            $_fillables = parent::getFillablesOnly(($leaveData));
            return parent::update($_fillables, $id);
        }

        public function adminApproval($leaveData) {
            $remarks = $leaveData['remarks'];

            if(isEqual($remarks, 'Declined')) {
                return $this->update([
                    'status' => 'declined',
                    'remarks' => 'declined by admin'
                ], $leaveData['id']);
            } else {
                return $this->update([
                    'remarks' => $remarks
                ], $leaveData['id']);
            }
        }

        private function _validateLeaveEntry($leaveData) {
            
            if($leaveData['start_date'] > $leaveData['end_date']) {
                $this->addError("Invalid date duration");
                return false;
            }

            return true;
        }

        private function _isMultipleDates($startDate, $endDate) {
             /**
             * duration
             */
            $dateDifference = date_difference($startDate, $endDate);
            $dateDifferenceNumber = str_to_number_only($dateDifference);

            if($dateDifferenceNumber >= 1) {
                return true;
            }else{
                return false;
            }
        }
        
        
        private function _multipleDate($leaveData) {
            /**
             * duration
             */
            $dateDifference = date_difference($leaveData['start_date'], $leaveData['end_date']);
            $dateDifferenceStr = str_to_str_only($dateDifference);
            $dateDifferenceNumber = str_to_number_only($dateDifference);
           
            if ($dateDifferenceStr == 'days' && $dateDifferenceNumber > 1) {
                $startingDate = $leaveData['start_date'];

                for ($i = 1 ; $i <= $dateDifferenceNumber; $i++) {
                    if($i > 1) {
                        $startingDate = date('Y-m-d', strtotime(' +1 day '.$startingDate));
                    }

                    $leaveData['start_date'] = $startingDate;
                    $leaveData['end_date'] = $startingDate;
                    $isOkay = $this->_addEntry($leaveData);
                }

                parent::addMessage("Multiple leave date has been created");
            } else {
                return false;
            }

            return true;
        }

        private function _addEntry($leaveData) {
            $_fillables = parent::getFillablesOnly($leaveData);

            if(!$this->_verifyLeavePoint($leaveData['user_id'], $leaveData['leave_category'])){
                $this->addError("Not enough leave points for {$leaveData['leave_category']}.");
                return false;
            }

            //deduct uf sucess
            $this->_deductLeavePoint($leaveData['user_id'], $leaveData['leave_category']);
            
            return parent::store($_fillables);
        }

        private function _verifyLeavePoint($userId, $leaveType) {
            $totalPoint = $this->leavePointModel->getTotalByUserSingle($userId, $leaveType)->total_point ?? 0;
            return $totalPoint > 0 ;
        }
        
        private function _deductLeavePoint($userId,$leaveType) {
            $this->leavePointModel->store([
                'user_id' => $userId,
                'leave_point_category' => $leaveType,
                'point' => -1,
                'remarks' => 'Leave Request : '.$leaveType
            ]);
        }
    }