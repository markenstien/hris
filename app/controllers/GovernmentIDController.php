<?php 

    class GovernmentIDController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = model('GovernmentIDModel');
        }

        /**
         * management only
         */
        public function index() {
            $govIds = $this->model->getAll(); 

            /**
             * group ids
             */

            $govIdsGroupByUser = [];

            foreach($govIds as $key => $row) {
                if(!isset($govIdsGroupByUser[$row->user_id])) {
                    $govIdsGroupByUser[$row->user_id] = [
                        'user_id'  => $row->user_id,
                        'user_full_name' => $row->user_full_name,
                        'user_user_code' => $row->user_user_code,
                        'is_okay_sss' => false,
                        'is_okay_philhealth' => false,
                        'is_okay_pagibig' => false,
                        'is_complete' => false
                    ];
                }
                switch($row->organization) {
                    case 'SSS':
                        $govIdsGroupByUser[$row->user_id]['is_okay_sss'] = $row->is_verified;
                    break;

                    case 'PHILHEALTH':
                        $govIdsGroupByUser[$row->user_id]['is_okay_philhealth'] = $row->is_verified;
                    break;

                    case 'PAGIBIG':
                        $govIdsGroupByUser[$row->user_id]['is_okay_pagibig'] = $row->is_verified;
                    break;
                }
            }

            foreach($govIdsGroupByUser as $key => $row) {
                if($row['is_okay_sss'] && $row['is_okay_pagibig'] && $row['is_okay_philhealth']) {
                    $govIdsGroupByUser[$key]['is_complete'] = true;
                }
            }

            $this->data['govIds'] = $govIds;
            $this->data['govIdsGroupByUser'] = $govIdsGroupByUser;

            return $this->view('government_id/index', $this->data);
        }


        public function edit($userId) {
            if(isSubmitted()){
                $post = request()->posts();

                $isOkay = $this->model->update([
                    'id_number' => $post['id_number']
                ], $post['id']);
                
                if($isOkay) {
                    Flash::set("ID Updated");
                }else{
                    Flash::set("Update failed", 'danger');
                }

                return redirect(_route('govid:edit', $userId));
            }
            $data = [
                'governmentIds' => $this->model->all(['user_id' => $userId]),
                'userId' => $userId
            ];

            $this->data = array_merge($data, $this->data);

            return $this->view('government_id/edit', $this->data);
        }

        /**
         * hr only
         */
        public function verification($userId) {
            if(isSubmitted()){
                $post = request()->posts();
                $isOkay = $this->model->update([
                    'is_verified' => true
                ], $post['id']);
                
                if($isOkay) {
                    Flash::set("Id Verified");
                }else{
                    Flash::set("Update failed", 'danger');
                }

                return redirect(_route('govid:verification', $userId));
            }
            $data = [
                'governmentIds' => $this->model->all(['user_id' => $userId]),
                'userId' => $userId
            ];

            $this->data = array_merge($data, $this->data);

            return $this->view('government_id/verification', $this->data);
        }
    }