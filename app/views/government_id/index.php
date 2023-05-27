<?php build('content')?>
<div class="col-md-12 mx-auto">
	<?php Flash::show()?>
	<div class="statbox widget box box-shadow">
		<div class="widget-header">
			<div class="row">
				<div class="col-xl-12 col-md-12 col-sm-12 col-12">
					<h4>Gonverment ID Details</h4>
				</div>
			</div>
		</div>

		<div class="widget-content widget-content-area">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>User Code</th>
                        <th>User Name</th>
                        <th>SSS</th>
                        <th>PAGIBIG</th>
                        <th>PHILHEALTH</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php
                            $check = '<i data-feather="check-circle" class="text-success"></i>';
                            $unchecked = '<i data-feather="x-circle" class="text-danger"></i>';
                        ?>
                        <?php foreach($govIdsGroupByUser as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row['user_user_code']?></td>
                                <td><?php echo $row['user_full_name']?></td>
                                <td><?php echo $row['is_okay_sss'] ? $check: $unchecked?></td>
                                <td><?php echo $row['is_okay_pagibig'] ? $check: $unchecked?></td>
                                <td><?php echo $row['is_okay_philhealth'] ? $check: $unchecked?></td>
                                <td><?php echo $row['is_complete'] ? '<span class="badge badge-success">Complete</span>' : '<span class="badge badge-warning">In-Complete</span>'?></td>
                                <td><?php echo wLinkDefault(_route('govid:verification', $row['user_id'],), 'Take Action')?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
		</div>

	</div>
</div>
<?php endbuild()?>
<?php loadTo()?>