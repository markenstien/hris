<?php extract($data)?>

<div class="table-responsive">
    <table class="table table-bordered dataTableAction">
        <thead>
            <th>#</th>
            <th>User</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Type</th>
            <th>Duration</th>
            <th>Status</th>
            <th>Remarks</th>
            <th>Action</th>
        </thead>

        <tbody>
            <?php foreach($timesheets as $key => $row) :?>
                <tr>
                    <td><?php echo ++$key?></td>
                    <td><?php echo $row->full_name?></td>
                    <td><?php echo $row->time_in?></td>
                    <td><?php echo $row->time_out?></td>
                    <td><?php echo $row->sheet_category?></td>
                    <td><?php echo timeInMinutesToHours($row->duration, true)?></td>
                    <td><?php echo $row->status?></td>
                    <td><?php echo $row->remarks?></td>
                    <td>
                        
                        <?php
                            echo wLinkDefault(_route('tk:show', $row->id), 'Show', [
                                'icon' => 'eye'
                            ]);

                            if(isEqual($row->status,'pending')) {
                                if(isManagement()) {
                                    echo wLinkDefault(_route('tk:approve', $row->id), 'Approve', [
                                        'icon' => 'check-circle',
                                        'class' => 'form-verify'
                                    ]);
                                }
                            } else {
                                if(isManagement()) {
                                    echo wLinkDefault(_route('tk:delete', $row->id), 'Delete', [
                                        'icon' => 'trash',
                                        'class' => 'form-verify'
                                    ]);
                                }
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
</div>