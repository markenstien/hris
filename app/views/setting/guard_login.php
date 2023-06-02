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
<body>
    <div class="col-md-3 mx-auto">
        <?php echo wDivider(70)?>
        <div class="text-center mb-5"> <img src="<?php echo _path_upload_get('logo.png')?>" alt="" style="width:150px"> </div>
        <h1>Login To Guard Panel</h1>
        <!-- <p class="signup-link">New Here? <a href="auth_register.html">Create an account</a></p> -->
        <?php echo $form->start()?>
            <div class="form">
                <?php Flash::show()?>
                <div id="username-field" class="field-wrapper input mb-3">
                    <?php echo $form->getCol('username')?>
                </div>

                <div id="password-field" class="field-wrapper input mb-4">
                    <?php echo $form->getCol('password')?>
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
        <?php echo wDivider(20)?>
        <?php echo wLinkDefault(_route('setting:guard-panel'),'Staff and Employee Login')?>
        <?php echo wDivider(40)?>
        <p class="terms-conditions">© <?php echo date('Y') ?> All Rights Reserved. 
        <a href="#"><?php echo APP_NAME?></a> is a product of <?php echo COMPANY_NAME?>.
        <a href="javascript:void(0);">Privacy</a>, and <a href="javascript:void(0);">Terms</a>.</p>
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