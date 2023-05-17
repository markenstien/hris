<?php build('content')?>
	<div class="card">
		<?php Flash::show()?>
		<div class="card-body">
			<form method="post" action="<?php echo _route('schedule:update')?>">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<th>Day</th>
							<th>Opening Time</th>
							<th>Closing Time</th>
							<th>Max Number of Visitors</th>
							<th>Is Shop Closed</th>
						</thead>

						<tbody>
							<?php foreach( $schedules as $key => $row) :?>
								<tr>
									<td><?php echo strtoupper($row->day)?></td>
									<td><input type="time" name="sched[<?php echo $row->id?>][opening_time]" 
										value="<?php echo $row->opening_time?>"></td>
									<td><input type="time" name="sched[<?php echo $row->id?>][closing_time]" 
										value="<?php echo $row->closing_time?>"></td>
									<td><input type="number" name="sched[<?php echo $row->id?>][max_visitor_count]" value="<?php echo $row->max_visitor_count?>"></td>
									<td><?php echo $row->is_shop_closed?></td>
								</tr>
							<?php endforeach?>
						</tbody>
					</table>
				</div>

				<input type="submit" name="" class="btn btn-primary" value="Save Schedule">
			</form>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>