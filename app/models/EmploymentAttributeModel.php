<?php 

    class EmploymentAttributeModel extends Model
    {
        public $table = 'employment_attributes';

        public function getAll($params = []) {
            $where = null;
            $order = null;

            if(!empty($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY {$params['order']}";
            }

            $this->db->query(
                "SELECT ea.*, parent.attr_name as parent_name,
                    parent.attr_abbr_name as parent_abbr_name
                    FROM {$this->table} as ea
                    LEFT JOIN {$this->table} as parent
                    on ea.parent_id = parent.id
                    {$where} {$order}"
            );

            return $this->db->resultSet();
        }

        public function createDepartment($eeData) {
            //search if department exists
            $single = parent::single([
                'attr_key' => 'DEPARTMENT',
                'attr_name' => $eeData['attr_name'],
            ]);

            if($single) {
                $this->addError("Department Already exists");
                return false;
            }

            return parent::store([
                'attr_key' => 'DEPARTMENT',
                'attr_name' => $eeData['attr_name'],
                'attr_abbr_name' => $eeData['attr_abbr_name']
            ]);
        }

        public function createPosition($eeData) {
            //search if department exists
            $single = parent::single([
                'attr_key' => 'POSITION',
                'attr_name' => $eeData['attr_name'],
            ]);

            if($single) {
                $this->addError("Position Already exists");
                return false;
            }

            return parent::store([
                'attr_key' => 'POSITION',
                'attr_name' => $eeData['attr_name'],
                'attr_abbr_name' => $eeData['attr_abbr_name'],
                'parent_id' => $eeData['parent_id']
            ]);
        }
    }