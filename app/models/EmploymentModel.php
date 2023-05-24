<?php 

    class EmploymentModel extends Model
    {
        public $table = 'employment_details';
        public $_fillables = [
            'department_id',
            'position_id',
            'reports_to',
            'salary_per_month',
            'salary_per_day',
            'employment_date',
            'user_id'
        ];

        public function create($employmentData) {
            $validData = parent::getFillablesOnly($employmentData);
            return parent::store($validData);
        }

        public function getAll($params = []) {
            $where = null;

            if(isset($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }
            
            $this->db->query(
                "SELECT user.id as user_id, user.*,
                    position.attr_name as position_name,
                    department.attr_name as department_name,
                    ed.*,concat(manager.first_name,' ',manager.last_name) as manager_name
                    
                    FROM {$this->table} as ed 
                    LEFT JOIN users as user 
                    ON ed.user_id = user.id
                    
                    LEFT JOIN employment_attributes as position
                    ON position.id = ed.position_id
                    
                    LEFT JOIN employment_attributes as department
                    ON department.id = ed.department_id
                    
                    LEFT JOIN users as manager
                    ON manager.id = ed.reports_to

                    {$where}"
            );
            return $this->db->resultSet();
        }

        public function getSingle($params) {
            return $this->getAll($params)[0] ?? false;
        }

        public function getByUser($userId) {
            return $this->getSingle(['user_id' => $userId]);
        }
    }