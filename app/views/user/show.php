<?php build('content')?>
    <div class="row">
        <div class="col-md-4">
            <div class="user-profile layout-spacing">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <h3 class="">Personal</h3>
                        <?php if(isManagement() || isEqual(whoIs('id'), $user->id)) :?>
                            <a href="<?php echo _route('user:edit', $employment->user_id)?>" class="mt-2 edit-profile">
                                <i data-feather="edit"></i>
                            </a>
                        <?php endif?>
                    </div>
                    <div class="text-center user-info">
                        <img src="<?php echo $user->profile ?? _path_tmp('assets/img/90x90.jpg')?>" alt="avatar" style="width:200px">
                        <p class=""><?php echo $employment->first_name . ' ' . $employment->last_name?></p>
                    </div>
                </div>
            </div>

            <div class="statbox widget box box-shadow mb-2">
                <div class="widget-header">
                    <h4>Employment Details</h4>
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
                            <?php if(isManagement() || isEqual(whoIs('id'), $user->id)) :?>
                                <tr>
                                    <td><?php echo $employmentForm->getLabel('employment_date')?></td>
                                    <td><?php echo $employment->employment_date?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $employmentForm->getLabel('employment_status')?></td>
                                    <td><?php echo $employment->employment_status?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $employmentForm->getLabel('salary_per_month')?></td>
                                    <td><a href="javascript:void(0)" id="salaryLink"><span data-content="<?php echo $employment->salary_per_month?>">Double click to show</span></a></td>
                                </tr>
                            <?php endif?>
                        </table>
                    </div>
                </div>
            </div>
            <?php if($schedule || isManagement() || isEqual(whoIs('id'), $employment->reports_to) || isEqual(whoIs('id'), $user->id)) :?>
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <h4>Schedule</h4>
                </div>

                <div class="widget-content widget-content-area">
                    <?php if(!$schedule) :?>
                        <?php if(isManagement() || isEqual(whoIs('id'), $employment->reports_to)) :?>
                            <?php echo wLinkDefault(_route('schedule:create', null, ['user_id' => $user->id]), 'Create Schedule')?>
                        <?php endif?>
                    <?php else:?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th>Day</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>Rest Day</th>
                                </thead>

                                <tbody>
                                    <?php $schedTodayId = $scheduleToday->id?>
                                    <?php foreach($schedule as $key => $row) :?>
                                        <tr <?php echo isEqual($schedTodayId , $row->id) ? "style='background:var(--success)'" : '' ?>>
                                            <td><?php echo $row->day?></td>
                                            <td><?php echo date_long($row->time_in , 'h:i:s A')?></td>
                                            <td><?php echo date_long($row->time_out , 'h:i:s A')?></td>
                                            <td>
                                                <?php if($row->is_off) :?>
                                                    <span class="badge badge-danger"> RD </span>
                                                <?php else:?>
                                                    <span class="badge badge-primary"> WD </span>
                                                <?php endif?>
                                            </td>
                                        </tr>
                                    <?php endforeach?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif?>
                </div>
            </div>
            <?php endif?>
        </div>

        <div class="col-md-8">
            <?php if(isManagement() || isEqual(whoIs('id'), $user->id)) :?>
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <h4>Leave Credits <?php if(authType(USER_HR)) {
                        ?> <a href="<?php echo _route('leave-point:create', $employment->user_id)?>"><i data-feather="edit"></i></a> <?php
                    }?></h4>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <?php foreach(Module::get('ee_leave')['categories'] as $key => $leaveCat) :?>
                                <tr>
                                    <td><?php echo $leaveCat?></td>
                                    <td><?php echo $leavePointArray[$leaveCat] ?? '0'?></td>
                                </tr>
                            <?php endforeach?>
                        </table>
                    </div>
                    
                </div>
            </div>
            <?php endif?>

            <?php if($certificates) :?>
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <h4>Training and Seminars</h4>
                </div>
                <div class="widget-content widget-content-area">
                    <table class="table table-bordered">
                        <thead>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Status</th>
                        </thead>
                        <?php foreach($certificates as $key => $row) :?>
                            <tr>
                                <td><?php echo $row->req_code?></td>
                                <td><?php echo wLinkDefault(_route('requirement:respondentView',$row->id, [
                                    'respondent_id' => $row->id,
                                    'cert_id' => $row->cert_id
                                ]), $row->req_title)?></td>
                                <td><span class="badge badge-primary"><?php echo $row->eerr_status?></span></td>
                            </tr>
                        <?php endforeach?>
                        </table>
                </div>
            </div>
            <?php endif?>
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

<?php build('scripts') ?>
    <script>
        $(document).ready(function(){
            
            $("#salaryLink").dblclick(function(e){
                let span = $(this).find('span');
                alert(span.data('content'));
            });
        });
    </script>
<?php endbuild()?>

<?php loadTo()?>