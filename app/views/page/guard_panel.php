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

    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo _path_tmp('plugins/table/datatable/datatables.css')?>">
    <link rel="stylesheet" type="text/css" href="<?php echo _path_tmp('plugins/table/datatable/dt-global_style.css')?>">
    <!-- END PAGE LEVEL STYLES -->

</head>
<body class="form">
    <div class="col-md-8 mx-auto">
        <div class="card mt-5">
            <div class="card-header text-center">
                <h4 class="card-title">Employee Attendance</h4>
                <?php echo wLinkDefault(_route('setting:guard-logout'), 'Logout')?>
            </div>

            <div class="card-body">
                <?php Flash::show()?>
                <div class="table-responsive">
                    <table class="table table-bordered dataTableAction">
                        <thead>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Logged In</th>
                            <th>Duration</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            <?php foreach($users as $key => $row):?>
                                <?php $isLoggedIn = false?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->full_name?></td>
                                    <td>
                                        <?php if($row->last_in && is_null($row->last_in->time_out)) :?>
                                            <p> <span class="badge badge-success"><?php echo date('h:i:s A', strtotime($row->last_in->time_in))?></span> </p>
                                            <?php $isLoggedIn = true?>
                                        <?php else:?>
                                            <p>Logged Out</p>
                                        <?php endif?>
                                    </td>
                                    <td>
                                        <?php if($isLoggedIn) :?>
                                            <?php echo time_since($row->last_in->time_in)?>
                                        <?php else:?>
                                            <p>...</p>
                                        <?php endif?>
                                    </td>
                                    <td>
                                        <?php if($isLoggedIn) :?>
                                            <?php echo wLinkDefault('#', 'Time-Out', [
                                                'data-userid' => $row->user_id,
                                                'data-action' => 'timeout',
                                                'class' => 'timesheet-action',
                                                'data-target' => '#exampleModal',
                                                'data-toggle' => 'modal'
                                            ])?>
                                        <?php else:?>
                                            <?php echo wLinkDefault('#', 'Time-In', [
                                                'data-userid' => $row->user_id,
                                                'data-action' => 'timein',
                                                'class' => 'timesheet-action',
                                                'data-target' => '#exampleModal',
                                                'data-toggle' => 'modal'
                                            ])?>
                                        <?php endif?>
                                    </td>
                                </tr>
                                
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verify Its you</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                        Form::open([
                            'method' => 'post',
                            'action' => _route('tk:log')
                        ]);
                        Form::hidden('user_id','', [
                            'id' => 'userId'
                        ]);
                    ?>
                        <div class="form-group">
                            <?php 
                                Form::label('Password');
                                Form::password('password','', [
                                    'class' => 'form-control',
                                    'required' => true
                                ])
                            ?>
                        </div>

                        <?php Form::submit('', 'Submit', ['class' => 'btn btn-primary btn-sm'])?>
                    <?php Form::close()?>
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

    <script src="<?php echo _path_tmp('plugins/table/datatable/datatables.js')?>"></script>
    <script>        
        $('.dataTableAction').DataTable( {
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "order": [[ 3, "desc" ]],
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7,
            drawCallback: function () { $('.dataTables_paginate > .pagination').addClass(' pagination-style-13 pagination-bordered'); }
	    } );
    </script>


	<script>
        $(document).ready(function() {

            $('.timesheet-action').click(function(){
                
                $('#userId').val($(this).data('userid'));
            });
            feather.replace();
        });
    </script>
    
    
</body>
</html>