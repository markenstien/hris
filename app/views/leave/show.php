<?php build('content') ?>
<div class="col-md-6">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Leave Request Admin Approval</h4>
            <?php echo wLinkDefault(_route('leave:index'), 'Back to list', ['icon' => 'arrow-left-circle'])?>
        </div>
        <div class="widget-content widget-content-area">
            <?php Flash::show()?>
            <div class="table-responsive">
                <table class="table table-bordered">
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

                    <tr>
                        <td>Status</td>
                        <td><?php echo $leave->status?></td>
                    </tr>
                    <tr>
                        <td>Remarks</td>
                        <td><?php echo $leave->remarks?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>