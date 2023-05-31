<?php build('content') ?>
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Leave Point</h4>
            <?php
                if(isHr()) {
                    echo wLinkDefault(_route('leave-point:create'), 'Add Leave Point');
                }
            ?>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive">
                <table class="table table-bordered <?php echo isAdmin() ? 'dataTableAction': 'dataTAble'?>">
                    <thead>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Leave Category</th>
                        <th>Point</th>
                        <th>Remarks</th>
                        <th>Date</th>
                    </thead>

                    <tbody>
                        <?php foreach($leave_point_logs as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->full_name?></td>
                                <td><?php echo amountHTML($row->point)?></td>
                                <td><?php echo $row->leave_point_category?></td>
                                <td><?php echo $row->remarks?></td>
                                <td><?php echo $row->created_at?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>