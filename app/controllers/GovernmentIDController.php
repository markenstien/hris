<?php 

    class GovernmentIDController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = model('GovernmentIDModel');
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
    }