<?php   

    class UserMetaModel extends Model 
    {

        public $table = 'user_meta';
        const minimumWorkHours = 8;

        public function getByUserid($userId)
        {
            $obj = new stdClass();
            $obj->rate_per_day = 765;
            $obj->rate_per_hour = 75;
            $obj->user_id = $userId;
            $obj->max_work_hours = self::minimumWorkHours;
            $obj->weekly_max_earning = 765;

            return $obj;
        }



        public function getComplete()

        {

            $this->wallet = model('WalletModel');



            $this->db->query(

                "SELECT user.id  as user_id ,

                    user.firstname as firstname ,

                    user.lastname as lastname ,

                    user.type,

                    user_meta.domain as domain,

                    user_meta.domain_user_token,

                    user_meta.rate_per_hour,

                    user_meta.rate_per_day,

                    user_meta.work_hours,

                    user_meta.bk_username as username,



                    ifnull(pera.account_number , 0) as pera_account_number



                    FROM users as user



                    LEFT JOIN $this->table as user_meta

                    ON user.id = user_meta.user_id



                    LEFT JOIN bank_pera_accounts as pera 

                    ON user.id = pera.user_id



                    WHERE user_meta.domain_user_token != '00000'

                    "

            );



            $results = $this->db->resultSet();



            foreach($results as $key => $user){

                $user->wallet  = $this->wallet->getTotal($user->user_id);

                $user->wallets = $this->wallet->getByUser($user->user_id);

            }



            return $results;

        }





        public function getByToken($token)

        {

            $this->wallet = model('WalletModel');



            $this->db->query(

                "SELECT user.id , user.firstname , 

                user.lastname , user.mobile ,

                user.type, 

                meta.domain_user_token ,

                meta.rate_per_hour,

                meta.rate_per_day,

                meta.work_hours,

                meta.max_work_hours,

                meta.id as meta_id

                

                FROM $this->table as meta 

                LEFT JOIN users as user 

                ON meta.user_id = user.id

                

                WHERE meta.domain_user_token = '$token' "

            );



            $user =  $this->db->single();



            if(!$user)

                return false;



           $user->wallet = $this->wallet->getTotal($user->id);

           $user->wallets = $this->wallet->getByUser($user->id);



           return $user;

        }



        public function getByTokenComplete($token)

        {

           $user = $this->getByToken($token);



           if(!$user)

            return false;

            

            $user->timesheets = $this->timesheet->getWithMetaByUser($user->id);



            return $user;

        }



        public function updateByToken($data , $token)

        {

            $data = [

                $this->table,

                $data,

                " domain_user_token  = '$token'"

            ];



            return $this->dbHelper->update(...$data);

        }


        public function updateWithRate($values)
        {

            $minWorkHours =  $values['min'];
            //convert hours and mins array to minutes
            $minWorkHours = hoursMinsToMinutes($minWorkHours['hours'] , $minWorkHours['minutes']);
            //convert minutes to hours
            $minWorkHours = timeInMinutesToHours($minWorkHours);
            ###CONVERT MAX WORK HOURS
            $maxWorkHours = $values['max'];
            //convert hours and mins array to minutes
            $maxWorkHours = hoursMinsToMinutes($maxWorkHours['hours'] , $maxWorkHours['minutes']);
            //convert minutes to hours
            $maxWorkHours = timeInMinutesToHours($maxWorkHours);

            $ratePerHour = $values['rate_per_day'] / $minWorkHours;

            $updateData = [
                'rate_per_hour' => $ratePerHour,
                'rate_per_day'  => $values['rate_per_day'],
                'work_hours'    => $minWorkHours,
                'max_work_hours' => $maxWorkHours,
                'weekly_max_earning' => $values['weekly_max_earning']
            ];

            return parent::update($updateData ,$values['id']);
        }

        public function getMaxWorkHours($userId)
        {
            return self::minimumWorkHours;
        }

        public function getWorkHours($userId)
        {
            return self::minimumWorkHours;
        }
    }