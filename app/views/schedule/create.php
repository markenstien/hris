<?php build('content') ?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Create Schedule For : <?php echo $user->first_name?></h4>
			<?php Flash::show()?>
		</div>

		<div class="card-body">
			<?php Form::open(['method' => 'post' , 'action' => _route('schedule:create')]) ?>
				<?php Form::hidden('user_id' , $user->id)?>
				<table class="table">
					<thead>
						<th>Day</th>
						<th>In</th>
						<th>Out</th>
						<th>Rest Day</th>
					</thead>

					<tbody>
						<?php foreach($daysoftheweek as $key => $day) :?>
							<tr>
								<td>
									<?php
										Form::hidden("day[{$key}][day]" , $day);
										echo $day;
									?>
								</td>
								<td>
									<?php
										Form::time("day[{$key}][time_in]" , '08:00');
									?>
								</td>
								<td>
									<?php
										Form::time("day[{$key}][time_out]" , '17:00');
									?>
								</td>
								<td>
									<label for="<?php echo "r-off{$key}"?>">
										<?php Form::radio("day[{$key}][rd]" , 1 , ['id' => "r-off{$key}"]) ?>
										Rest Day
									</label>
									<label for="<?php echo "w-off{$key}"?>">
										<?php Form::radio("day[{$key}][rd]" , 0 , ['id' => "w-off{$key}" , 'checked' => '']) ?>
										Work Day
									</label>
								</td>
							</tr>
						<?php endforeach?>
					</tbody>
				</table>

			<?php
				Form::submit('' , 'Save Schedule');
			?>
			<?php Form::close()?>	
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>