<?php 

    class LeavePointModel extends Model
    {
        public $table = 'leave_points';
        public $_fillables = [
            'user_id',
            'point',
            'remarks',
            'leave_point_category'
        ];

        public function addEntry($pointData) {

            if(!$this->_isValidPoint($pointData['point'])) {
                return false;
            }

            $_fillables = parent::getFillablesOnly($pointData);
            $_fillables['point'] = $this->_convertPointByEntry($pointData['point'], $pointData['point_type']);
            $_fillables['created_by'] = whoIs('id');

            return parent::store($_fillables);
        }
        public function getTotalByUser($userId, $leaveType = null) {

            if(!is_null($leaveType)) {
                $leaveType = " AND leave_point_category = '{$leaveType}' ";
            }
            $this->db->query(
                "SELECT SUM(point) as total_point,
                    leave_point_category, user_id
                
                FROM {$this->table}
                WHERE user_id = '{$userId}' {$leaveType}
                GROUP BY user_id, leave_point_category"
            );

            return $this->db->resultSet();
        }

        public function getTotalByUserSingle($userId, $leaveType = null) {
            return $this->getTotalByUser($userId,$leaveType)[0] ?? false;
        }

        public function getAll($params = []) {

            $where = null;
            $order = null;
            $limit = null;
            if(!empty($params['where'])) {
                $where = " WHRE ".parent::conditionConvert($params['where']);
            }

            if(!empty($params['order'])) {
                $order = "ORDER BY {$params['order']}";
            } else {
                $order = " ORDER BY lp.id desc";
            }

            if(!empty($params['limit'])) {
                $limit = "LIMIT{$params['limit']}";
            } else {
                $limit = "LIMIT 20";
            }

            $this->db->query(
                "SELECT lp.*, concat(user.first_name, ' ' ,user.last_name) as full_name,
                    user.first_name , user.last_name
                    FROM {$this->table} as lp

                    LEFT JOIN users as user
                    on lp.user_id = user.id
                    {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }

        private function _isValidPoint($point) {
            $isOkay = $point >= 0;

            if(!$isOkay) {
                $this->addError("Invalid Point");
            }

            return $isOkay;
        }
        private function _convertPointByEntry($point, $pointType) {
            if(isEqual($pointType, 'deduct')) {
                $point *= -1;
            }
            return $point;
        }
    }