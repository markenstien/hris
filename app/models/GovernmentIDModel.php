<?php 

    class GovernmentIDModel extends Model
    {
        public $table = 'government_ids';
        public $_fillables = [
            'user_id',
            'organization',
            'id_number',
            'remarks'
        ];
        public $organizations = [
            'SSS','PAGIBIG','PHILHEALTH'
        ];

        /**
         * run every new employee is created
         */
        public function _createRecord($userId) {
            foreach($this->organizations as $key => $row) {
                $isOkay = $this->store([
                    'user_id' => $userId,
                    'organization' => $row,
                    'is_verified' => false
                ]);
            }
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY {$params['order']}";
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT {$params['limit']}";
            }

            $this->db->query(
                "SELECT gov.*, concat(user.first_name, ' ',user.last_name) as user_full_name,
                    user.user_code as user_user_code 
                    
                    FROM {$this->table} as gov
                    LEFT JOIN users as user
                    ON gov.user_id = user.id
                    {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }
    }