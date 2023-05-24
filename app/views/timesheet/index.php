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
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>User</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Duration</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </thead>

                    <tbody>
                        <?php foreach($timesheets as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->full_name?></td>
                                <td><?php echo $row->time_in?></td>
                                <td><?php echo $row->time_out?></td>
                                <td><?php echo timeInMinutesToHours(timeDifferenceInMinutes($row->time_in, $row->time_out), true)?></td>
                                <td><?php echo $row->amount?></td>
                                <td><?php echo $row->status?></td>
                                <td><?php echo $row->remarks?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>