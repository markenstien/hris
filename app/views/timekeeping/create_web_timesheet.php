<?php build('page-control')?>
	<div class="widget widget-content-area page-command-container">
		<a href="<?php echo _route('user:create')?>" 
			class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm">Web</a>

        <a href="<?php echo _route('user:create')?>" 
			class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm">Timesheet</a>

        <a href="<?php echo _route('user:create')?>" 
			class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm">Timesheet</a>
	</div>
<?php endbuild()?>

<?php build('content') ?>
<div class="statbox widget box box-shadow">
    <div class="widget-header">
        <h4 class="widget-title">Web Clock In</h4>
    </div>

    <div class="widget-content widget-content-area">
        <a href="<?php echo _route('tk:weblog')?>" class="btn btn-primary btn-lg">Clock In</a>
    </div>

    <div class="widget-content widget-content-area">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Date</th>
                    <th>Amount</th>
                </thead>

                <tbody>
                    <?php foreach($timesheets as $key => $row) :?>
                        <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->time_in?></td>
                            <td><?php echo $row->time_out?></td>
                            <td><?php echo date('Y-m-d', strtotime($row->time_in))?></td>
                            <td><?php echo amountHTML($row->amount)?></td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>