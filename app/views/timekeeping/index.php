<?php build('page-control')?>
    <div class="widget widget-content-area page-command-container">
        <?php if(authType([USER_HR,USER_EMP])) :?>
            <a href="<?php echo _route('tk:create', null, [
                'user_id' => seal(whoIs('id')),
                'type' => 'manual_form'
            ])?>"  title="File Ac"
                class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i data-feather="plus-circle"></i></a>
        <?php endif?>

        <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-sm">
            <i data-feather="filter"></i>
        </button>        
    </div>
<?php endbuild()?>


<?php build('content') ?>
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Timesheets</h4>
        </div>

        <div class="widget-content widget-content-area">
            <?php Flash::show()?>
            <?php grab($fullViewPath, [
                'timesheets' => $timesheets,
                'usersTimesheets' => $usersTimesheets ?? ''
            ])?>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <?php Form::open(['method' => 'get'])?>
                        <?php echo $_formCommon->getCol('start_date');  ?>
                        <?php echo $_formCommon->getCol('end_date');  ?>
                        <div class="mt-2 form-grou">
                            <?php
                                Form::label('User');
                                Form::select('user_id', $userArray, '', [
                                    'class' => 'form-control'
                                ]);
                            ?>
                        </div>
                        
                        <div class="mt-2">
                            <?php
                                Form::label('View Type');
                                Form::select('view_type', Module::get('timesheet')['view_type'], 'free_list', [
                                    'class' => 'form-control'
                                ]);
                            ?>
                        </div>
                        
                        <div class="mt-2">
                            <?php Form::submit('btn_filter', 'Apply Filter')?>
                        </div>
                    <?php Form::close()?>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>