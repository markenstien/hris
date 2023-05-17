<?php build('content') ?>
	
	<div class="col-md-8 mx-auto">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Report</h4>
			</div>

			<div class="card-body">
				<div class="col-md-8 mx-auto">
					<h5 class="text-center">Report Filter</h5>
					<?php Form::open(['method' => 'get'])?>
						<div class="form-group row">
							<div class="col">
								<?php
									Form::label('Start Date');
									Form::date('start_date' , '' , ['class' => 'form-control' , 'required' => true])
								?>
							</div>
							<div class="col">
								<?php
									Form::label('End Date');
									Form::date('end_date' , '' , ['class' => 'form-control' , 'required' => true])
								?>
							</div>
						</div>
						<div class="form-group">
							<?php
								Form::label('Report Type');
								Form::select('report_type' ,['daily' , 'monthly' , 'yearly'],'' , ['class' => 'form-control' , 'required' => true])
							?>
						</div>
						<div>
							<?php Form::submit('report_create' , 'Create Report')?>
						</div>
					<?php Form::close()?>
				</div>
			</div>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>