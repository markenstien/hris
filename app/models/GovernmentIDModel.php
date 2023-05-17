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
    }