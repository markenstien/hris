<?php build('content') ?>
<div class="col-md-6">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Leave Request Admin Approval</h4>
            <?php echo wLinkDefault(_route('leave:index'), 'Back to list', ['icon' => 'arrow-left-circle'])?>
        </div>
        <div class="widget-content widget-content-area">
            <?php Form::open(['method' => 'post'])?>
            <?php Form::hidden('id', $leave->id)?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td><?php Form::select('remarks', Module::get('ee_leave')['admin-approval-category'], $leave->remarks , ['class' => 'form-control', 'required' => true])?></td>
                        <td><?php Form::submit('', 'Apply')?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:var(--primary);color:#fff">Leave Info</td>
                    </tr>
                    <tr>
                        <td>Employee</td>
                        <td><?php echo $leave->user_full_name?></td>
                    </tr>
                    <tr>
                        <td>Reason</td>
                        <td><?php echo $leave->leave_category?></td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td><?php echo $leave->start_date?></td>
                    </tr>
                    <tr>
                        <td>Approved By</td>
                        <td><?php echo $leave->approver_full_name?></td>
                    </tr>
                </table>
            </div>
            <?php Form::close()?>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>