<?php build('page-control')?>
    <div class="widget widget-content-area page-command-container">
        <?php if(authType([USER_EMP])) :?>
            <a href="<?php echo _route('leave:create', null)?>" 
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
        <h4>Leave Request</h4>
        <?php if(isset($_GET['filter'])) :?>
            <?php echo wLinkDefault(_route('leave:index'), 'Remove Filter', ['icon' => 'x'])?>
        <?php endif?>
    </div>
    <div class="widget-content widget-content-area">
        <?php Flash::show()?>
        <div class="table-responsive">
            <table class="table table-bordered <?php echo isManagement() ? 'dataTableAction' : 'dataTable'?>">
                <thead>
                    <th>#</th>
                    <th>User</th>
                    <th>Category</th>

                    <th>Reference Date</th>
                    <th>Start Date</th>
                    <th>End Date</th>

                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Approved By</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    <?php foreach($leaves as $key => $row) : ?>
                        <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->user_full_name?></td>
                            <td><?php echo $row->leave_category?></td>

                            <td><?php echo $row->date_filed?></td>
                            <td><?php echo $row->start_date?></td>
                            <td><?php echo $row->end_date?></td>

                            <td><?php echo $row->status?></td>
                            <td><?php echo $row->remarks?></td>
                            <td><?php echo $row->approver_full_name?></td>
                            <td>
                                <?php
                                    if(isEqual(whoIs('id'), $row->user_id) && isEqual($row->status,'pending')) {
                                        $noAction = true;
                                        echo wLinkDefault(_route('leave:edit', $row->id), '', [
                                            'icon' => 'edit'
                                        ]);
                                    }

                                    if(authType([USER_EMP]) && isEqual($row->status,'pending')) {
                                        echo wLinkDefault(_route('leave:delete', $row->id), '', [
                                            'icon' => 'trash',
                                            'class' => 'text-danger form-verify'
                                        ]);
                                    }
                                ?>
                                <?php 
                                    if(isHr() && isEqual($row->status,'pending')) {
                                        $noAction = true;
                                        echo wLinkDefault(_route('leave:approve', $row->id), '', [
                                            'icon' => 'check-circle'
                                        ]);
                                    }
                                ?>
                                <?php
                                    if(isAdmin() && empty($row->remarks)) {
                                        $noAction = true;
                                        echo wLinkDefault(_route('leave:admin-approval', $row->id), '', [
                                            'icon' => 'check-circle',
                                            'class' => 'btn btn-sm btn-secondary'
                                        ]);
                                    }  
                                ?>
                            </td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Leave Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-text">
                    <?php
                        Form::open([
                            'method' => 'get',
                            'action' => ''
                        ])
                    ?>
                        <?php echo $form->getCol('status', [
                            'required' => true
                        ])?>
                        <?php echo $form->getCol('user_id')?>
                        <?php echo $form->getCol('leave_category', [
                            'required' => false
                        ])?>
                        <?php echo $form->getCol('remarks')?>

                        <div class="mt-2">
                            <?php Form::submit('filter', 'Apply Filter')?>
                        </div>
                    <?php Form::close()?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php endbuild()?>
<?php loadTo()?>