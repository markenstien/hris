<?php
    use Form\UserForm;
    load(['UserForm'], FORMS);

    class SettingsController extends Controller
    {
        private $commonMetaModel, $userForm;

        const USER_GUARD = 'USER_GUARD';

        public function __construct()
        {
            parent::__construct();
            $this->commonMetaModel = model('CommonMetaModel');
            $this->userForm = new UserForm();
            $this->data['form'] = $this->userForm;
        }

        public function manageGuard() {
    
            if(isSubmitted()) {
                $post = request()->posts();

                if(strlen($post['meta_key']) < 4 || strlen($post['meta_value']) < 4) {
                    Flash::set("Username and password must atleast be 4 characters long",'danger');
                    return request()->return();
                }

                $this->commonMetaModel->update([
                    'meta_key' => $post['meta_key'],
                    'meta_value' => $post['meta_value'],
                ], [
                    'meta_category' => self::USER_GUARD
                ]);

                Flash::set("guard data updated");
            }

            $this->insertGuardIfNotExists();

            $this->data['guard_data'] = $this->commonMetaModel->single([
                'meta_category' => self::USER_GUARD
            ]);
            return $this->view('setting/guard_manage',$this->data);
        }

        private function insertGuardIfNotExists() {
            $defaultUsername = 'guard_a';
            $defaultPassword = '1111';

            $guard = $this->commonMetaModel->single([
                'meta_category' => self::USER_GUARD
            ]);

            if(!$guard) {
                $this->commonMetaModel->store([
                    'meta_key' => $defaultUsername,
                    'meta_value' => $defaultPassword,
                    'meta_category' => self::USER_GUARD
                ]);
            }
        }

        public function logoutGuard() {
            Session::remove('guard-user');
            Flash::set("Guard has been logged out");
            return redirect(_route('auth:login'));
        }
        public function panelGuard() {
            
            if(isSubmitted()) {
                $post = request()->posts();

                $guard = $this->commonMetaModel->single([
                    'meta_key' => $post['username'],
                    'meta_category' => self::USER_GUARD
                ]);

                if(!$guard) {
                    Flash::set("Guard userename not found",'danger');
                    return request()->return();
                } else {
                    if(!isEqual($guard->meta_value, $post['password'])) {
                        Flash::set("Invalid password");
                        return request()->return();
                    }

                    Session::set('guard-user', $guard);
                    return redirect(_route('page:index'));
                }
            }

            if(Session::get('guard-user')) {
                return redirect(_route('page:index'));
            } else {

                $this->userForm->init([
                    'url' => _route('setting:guard-panel')
                ]);

                $this->data['form'] = $this->userForm;

                return $this->view('setting/guard_login', $this->data);
            }
        }
    }