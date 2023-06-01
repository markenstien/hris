<?php build('content')?>
    <div class="row">
        <div class="col-md-4">
            <div class="user-profile layout-spacing">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <h3 class="">Personal</h3>
                        <a href="<?php echo _route('user:edit', $user->id)?>" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                    </div>
                    <div class="text-center user-info">
                        <img src="<?php echo $user->profile ?? _path_tmp('assets/img/90x90.jpg')?>" alt="avatar" style="width:200px">
                        <p class=""><?php echo $user->first_name . ' ' . $user->last_name?></p>
                        <div><i data-feather="coffee"></i> <?php echo $user->user_type?></div>
                    </div>
                </div>
            </div>

            <div class="statbox widget box box-shadow mb-2">
                <div class="widget-header">
                    <h4>Personal Details</h4>
                </div>

                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td><?php echo $_form->getLabel('email')?></td>
                                <td><?php echo $user->email?></td>
                            </tr>
                            <tr>
                                <td><?php echo $_form->getLabel('phone_number')?></td>
                                <td><?php echo $user->phone_number?></td>
                            </tr>
                            <tr>
                                <td><?php echo $_form->getLabel('address')?></td>
                                <td><?php echo $user->address?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('headers')?>
    <link href="<?php echo _path_tmp('assets/css/users/user-profile.css')?>" rel="stylesheet" type="text/css" />
<?php endbuild()?>


<?php build('styles')?>
    <style type="text/css">
        .hover-show-delete:hover .hidden-delete-button
        {
            display: block;
        }
        
        .hidden-delete-button
        {
            display: none;
        }
    </style>
<?php endbuild()?>


<?php loadTo()?>