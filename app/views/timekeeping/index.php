<?php build('page-control')?>
	<div class="widget widget-content-area page-command-container">
		<a href="<?php echo _route('tk:create', null, [
            'user_id' => seal(whoIs('id')),
            'type' => 'manual_form'
        ])?>"  title="File Ac"
			class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i data-feather="plus-circle"></i></a>
	</div>
<?php endbuild()?>


<?php build('content') ?>
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Timesheets</h4>
        </div>

        <div class="widget-content widget-content-area">
            <?php Flash::show()?>
            <div class="table-responsive">
                <table class="table table-bordered dataTable">
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
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>