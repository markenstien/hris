<?php build('content') ?>
	
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered dataTable">
					<thead>
						<th>#</th>
						<th>Guest Name</th>
						<th>Doctor</th>
						<th>Date</th>
						<th>Date Recorded</th>
						<th>Action</th>
					</thead>

					<tbody>
						<?php foreach($sessions as $key => $row) :?>
							<tr>
								<td><?php echo ++$key?></td>
								<td><?php echo $row->guest_name?></td>
								<td><?php echo $row->first_name . ' '.$row->last_name?></td>
								<td><?php echo $row->date_created?></td>
								<td><?php echo $row->created_at?></td>
								<td>
									<?php
										__( btnView(_route('session:show' , $row->id), "Show"));
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