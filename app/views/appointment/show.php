<?php build('content')?>
	<?php Flash::show()?>
	<div class="row">
		<div class="col-md-7">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Appointment</h4>
					<label><?php echo $appointment->type?></label>
				</div>

				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td>Date</td>
								<td><?php echo $appointment->date?></td>
							</tr>
							<tr>
								<td>Arrival Time</td>
								<td><?php echo $appointment->start_time?></td>
							</tr>

							<tr>
								<td>Type</td>
								<td><?php echo $appointment->type?></td>
							</tr>


							<tr>
								<td>Status</td>
								<td><?php echo $appointment->status?></td>
							</tr>


							<tr>
								<td>Guest</td>
								<td><?php echo $appointment->guest_name?></td>
							</tr>

							<tr>
								<td>Email</td>
								<td><?php echo $appointment->guest_email?></td>
							</tr>

							<tr>
								<td>Mobile</td>
								<td><?php echo $appointment->guest_phone?></td>
							</tr>

						</table>
					</div>
				</div>

				<!-- IF DOCTOR ACCOUNT IS LOGGED IN -->

				<?php if( !isEqual($appointment->status , 'arrived') && isEqual(auth('user_type') , ['admin' , 'doctor'])):?>
					<a href="<?php echo _route('session:create' , $appointment->id)?>" class="btn btn-danger"> Start Session Session</a>
				<?php endif?>
				<!-- -->
				<!-- cash payment -->
				<?php if(!$is_paid && $appointment->bill && isEqual(auth('user_type') , ['admin' , 'doctor'])) :?>
					<div class="card-body">
						<h4 class="card-title">Bill</h4>
						<?php
							Form::open([
								'method' => 'post',
								'action' => _route('bill:payInCash' , $appointment->bill->id)
							]);
						?>

						<div class="form-group">
							<?php Form::text('acc_name' , $bill->bill_to_name , ['class' => 'form-control' , 'required']);?>
						</div>

						<div>
							<?php Form::submit('', 'Pay In Cash', ['class' => 'btn btn-primary btn-sm'])?>
						</div>
						<?php Form::close()?>
					</div>
				<?php endif?>

				<?php if(isset($payment) && $payment) :?>
					<div class="card-body">
						<div class="card-title">Payments</div>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<th>Reference</th>
									<th>Amount</th>
									<th>Method</th>
									<th>created_at</th>
								</thead>
								<tr>
									<td><?php echo $payment->reference?></td>
									<td><?php echo $payment->amount?></td>
									<td><?php echo $payment->method	?></td>
									<td><?php echo $payment->created_at?></td>
								</tr>
							</table>

							<?php if($payment->external_reference) :?>
								<table class="table table-bordered">
									<thead>
										<th>ORG</th>
										<th>External Reference</th>
										<th>Account Number</th>
										<th>Account Name</th>
									</thead>
									<tbody>
										<tr>
											<td><?php echo $payment->org?></td>
											<td><?php echo $payment->external_reference?></td>
											<td><?php echo $payment->acc_no?></td>
											<td><?php echo $payment->acc_name?></td>
										</tr>
									</tbody>
								</table>
							<?php endif?>
						</div>
					</div>
				<?php endif?>
			</div>
		</div>
		<?php if(!$appointment->bill) :?>
			<div class="col-md-5">
				<h4>No Bill</h4>
			</div>
		<?php endif?>
		<?php if($appointment->bill && !$is_paid) :?>
			<div class="col-md-5">
				<h4>Pay by bank</h4>
				<iframe src="<?php echo _route('bill:fetchFrame' , $appointment->bill->id)?>"
						style="width: 100%; height: 100vh"></iframe>
			</div>
		<?php endif?>

		<?php if($appointment->bill && $is_paid) :?>
			<div class="col-md-5">
				<h4>Bill</h4>
				<iframe src="<?php echo _route('bill:fetchFrame' , $appointment->bill->id , ['type' => 'bill_only'])?>"
						style="width: 100%; height: 100vh"></iframe>
			</div>
		<?php endif?>
	</div>
<?php endbuild()?>
<?php loadTo()?>