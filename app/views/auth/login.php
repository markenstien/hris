<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo COMPANY_NAME?></title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo _path_tmp('bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo _path_tmp('assets/css/plugins.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo _path_tmp('assets/css/authentication/form-1.css')?>" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo _path_tmp('assets/css/forms/theme-checkbox-radio.css')?>">
    <link rel="stylesheet" type="text/css" href="<?php echo _path_tmp('assets/css/forms/switches.css')?>">
</head>
<body class="form">
    <div class="col-md-8 mx-auto">
        <div class="form-container">
            <div class="form-form">
                <div class="form-form-wrap">
                        <div class="form-container">
                            <div class="form-content">
                                <div class="text-center mb-5"> <img src="<?php echo _path_upload_get('logo.png')?>" alt="" style="width:150px"> </div>
                                <h1>Login To <span class="brand-name"><?php echo APP_NAME?></h1>
                                <!-- <p class="signup-link">New Here? <a href="auth_register.html">Create an account</a></p> -->
                                <?php echo $form->start()?>
                                    <div class="form">
                                        <?php Flash::show()?>
                                        <div id="username-field" class="field-wrapper input">
                                            <i data-feather="mail"></i>
                                            <?php echo $form->get('email')?>
                                        </div>

                                        <div id="password-field" class="field-wrapper input mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                            <?php echo $form->get('password')?>
                                        </div>
                                        <div class="d-sm-flex justify-content-between">
                                            <div class="field-wrapper toggle-pass">
                                                <p class="d-inline-block">Show Password</p>
                                                <label class="switch s-primary">
                                                    <input type="checkbox" id="toggle-password" class="d-none">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="field-wrapper">
                                                <button type="submit" class="btn btn-primary" value="">Log In</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php echo $form->end()?>
                                <p class="terms-conditions">© <?php echo date('Y') ?> All Rights Reserved. 
                                    <a href="#"><?php echo APP_NAME?></a> is a product of <?php echo COMPANY_NAME?>.
                                    <a href="javascript:void(0);">Privacy</a>, and <a href="javascript:void(0);">Terms</a>.</p>

                            </div>                    
                        </div>
                    </div>
            </div>
        </div>
    </div>

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo _path_tmp('assets/js/libs/jquery-3.1.1.min.js')?>"></script>
    <script src="<?php echo _path_tmp('bootstrap/js/popper.min.js')?>"></script>
    <script src="<?php echo _path_tmp('bootstrap/js/bootstrap.min.js')?>"></script>
    
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo _path_tmp('assets/js/authentication/form-1.js')?>"></script>
	<script src="<?php echo _path_tmp('plugins/font-icons/feather/feather.min.js')?>"></script>
	<script>
        $(document).ready(function() {
            feather.replace();
        });
    </script>
</body>
</html>