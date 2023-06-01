<?php build('content') ?>
<div class="col-md-5">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Timekeeping Preview</h4>
            <?php echo wLinkDefault(_route('tk:index'), 'Back to list', [
                'icon' => 'arrow-left-circle'
            ])?>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Employee</td>
                        <td><?php echo $timesheet->full_name?></td>
                    </tr>

                    <tr>
                        <td>Time In</td>
                        <td><?php echo $timesheet->time_in?></td>
                    </tr>

                    <tr>
                        <td>Time Out</td>
                        <td><?php echo $timesheet->time_in?></td>
                    </tr>

                    <tr>
                        <td>Duration</td>
                        <td><?php echo timeInMinutesToHours($timesheet->duration, true)?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><?php echo $timesheet->status?></td>
                    </tr>

                    <?php if($timesheet->approved_by) :?>
                    <tr>
                        <td>Approved By</td>
                        <td><?php echo $timesheet->approver_full_name?></td>
                    </tr>
                    <?php endif?>

                    <?php if(isEqual($timesheet->status, 'pending') && isManagement()) :?>
                    <tr>
                        <td>Action</td>
                        <td>
                            <?php
                                echo wLinkDefault(_route('tk:approve', $timesheet->id), 'Approve', [
                                    'icon' => 'check-circle'
                                ]);
                            ?>
                        </td>
                    </tr>
                    <?php endif?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>