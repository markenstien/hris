<?php build('content') ?>
<div class="container">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-5">
					<div class="row">
						<div class="col-md-5">
							<div>
								<?php if($user->profile) :?>
								<img src="<?php echo $user->profile?>" style="width: 150px;">
								<?php else:?>
									<label>No Profile Picture</label>
								<?php endif?>
							</div>
							<?php echo wDivider()?>
							<?php __(anchor(_route('user:edit' , $user->id) , 'Edit')) ?>
							<?php __(anchor(_route('user:delete' , $user->id , ['route' => seal(_route('user:index')) ]) , 'delete' , 'Delete' , 'danger')) ?>
						</div>

						<div class="col-md-7">
							<h4><?php echo $user->last_name?>, <?php echo $user->first_name?></h4>
							<div><span class="badge badge-primary"><?php echo $user->user_code?></span> (<?php echo $user->user_type?>)</div>
						</div>
					</div>
					<?php echo wDivider()?>
					<div>
						<div><strong>Referral Link</strong></div>
						<?php echo URL.DS._route('user:register', null, ['backer_id' => seal([
							$user->user_code,
							$user->id
						])])?>
					</div>
					<?php if(isset($backer)) :?>
						<?php echo wDivider()?>
						<div>
							<div><strong>Backer</strong></div>
							<?php echo $backer->first_name .  ' '.$backer->last_name?>
						</div>
					<?php endif?>
				</div>
				<div class="col-md-7">
					<div class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td>Gender</td>
								<td><?php echo $user->gender?></td>
							</tr>

							<tr>
								<td>Birth Date</td>
								<td><?php echo $user->birthdate?></td>
							</tr>

							<tr>
								<td colspan="2">Contact & Address</td>
							</tr>

							<tr>
								<td>Phone Number</td>
								<td><?php echo $user->phone_number?></td>
							</tr>

							<tr>
								<td>Email</td>
								<td><?php echo $user->email?></td>
							</tr>

							<tr>
								<td>Address</td>
								<?php if( isset($user->address_atomic_text) ) :?>
									<td>
										<?php echo $user->address_atomic_text?>
									</td>
								<?php endif?>
							</tr>
						</table>
					</div>
				</div>
			</div>	
		</div>
	</div>

	<?php echo wDivider()?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Sessions</h4>
			<?php echo anchor(_route('session:create', null, ['user_id' => $user->id]) , 'Create' , 'Create')?>
		</div>

		<div class="card-body">
			<table class="table table-bordered dataTable">
				<thead>
					<th>Doctor</th>
					<th>Remarks</th>
					<th>Date</th>
					<th>Action</th>
				</thead>
				<tbody>
					<?php foreach($sessions as $row):?>
						<tr>
							<td><?php echo $row->first_name . ' '.$row->last_name?></td>
							<td><?php echo $row->remarks?></td>
							<td><?php echo $row->date_created?></td>
							<td><?php echo anchor( _route('session:show' , $row->id), 'view' , 'show')?></td>
						</tr>
					<?php endforeach?>
				</tbody>
			</table>
		</div>
	</div>
	<?php echo wDivider()?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Appointments</h4>
			<?php echo anchor(_route('appointment:create' , $user->id) , 'Create' , 'Appointments')?>
		</div>

		<div class="card-body">
			<table class="table table-bordered dataTable">
				<thead>
					<th>Reference</th>
					<th>Type</th>
					<th>Status</th>
					<th>Date</th>
					<th>Action</th>
				</thead>
				<tbody>
					<?php foreach($appointments as $row):?>
						<tr>
							<td><?php echo $row->reference?></td>
							<td><?php echo $row->type?></td>
							<td><?php echo $row->status?></td>
							<td><?php echo $row->date?></td>
							<td><?php echo anchor( _route('appointment:show' , $row->id), 'view' , 'show')?></td>
						</tr>
					<?php endforeach?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php endbuild()?>
<?php loadTo()?>