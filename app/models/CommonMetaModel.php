<?php 

    class CommonMetaModel extends Model
    {
        public $table = 'common_meta';
        public $_fillables = [
            'parent_id',
            'meta_key',
            'meta_value',
            'user_id'
        ];

        public function createOrUpdate($data, $id = null) {
            $_fillables = parent::getFillablesOnly($data);
            if(!is_null($id)) {
                $retVal = parent::update($_fillables, $id);
            }else{
                $retVal = parent::store($_fillables);
            }
            return $retVal;
        } 

        public function createVerifyUserCode($userId) {
            $code = strtoupper(get_token_random_char(4));
            $id = parent::store([
                'meta_key' => 'USER_REGISTRATION_VERIFY',
                'parent_id' => $userId,
                'meta_value' => $code
            ]);

            $this->retVal['code'] = $code;
            $this->retVal['id'] = $id;

            return $id;
        }
    }