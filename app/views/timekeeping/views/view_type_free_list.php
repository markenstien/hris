<?php extract($data)?>

<div class="table-responsive">
    <table class="table table-bordered <?php echo isAdmin() ? 'dataTableAction' : 'dataTable'?>">
        <thead>
            <th>#</th>
            <th>User</th>
            <th>Position</th>
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
                    <td><?php echo $row->position_abbr_name?></td>
                    <td><?php echo $row->time_in?></td>
                    <td><?php echo $row->time_out?></td>
                    <td><?php echo $row->sheet_category?></td>
                    <td><?php echo timeInMinutesToHours(timeDifferenceInMinutes($row->time_in, $row->time_out), true)?></td>
                    <td><?php echo $row->status?></td>
                    <td><?php echo $row->remarks?></td>
                    <td>
                        
                        <?php
                            if(isEqual($row->status,'pending')) {
                                echo wLinkDefault(_route('tk:edit', $row->id), 'Edit', [
                                    'icon' => 'edit'
                                ]);
                                

                                if(isEqual(whoIs('user_type'),'staff') || isEqual($row->reports_to, whoIs('id'))) {
                                    echo wLinkDefault(_route('tk:approve', $row->id), 'Approve', [
                                        'icon' => 'check-circle'
                                    ]);
                                }
                            } else {
                                if(isEqual(whoIs('user_type'),'staff') || isEqual($row->reports_to, whoIs('id'))) {
                                    echo wLinkDefault(_route('tk:delete', $row->id), 'Delete', [
                                        'icon' => 'trash',
                                        'class' => 'btn btn-danger btn-sm'
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