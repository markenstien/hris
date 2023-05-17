<?php build('content') ?>
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<?php if(isset($session->patient_account) && $session->patient_account->profile) :?>
						<div class="col-md-2"><img src="<?php echo $session->patient_account->profile?>" style="width: 70px; height: 70px;"></div>
						<?php endif?>
						<div class="col">
							<h2><?php echo $session->guest_name?></h2>
							<label>Patient</label>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td>Name</td>
								<td><?php echo $session->guest_name?></td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><?php echo $session->guest_gender?></td>
							</tr>
							<tr>
								<td>Contact Number</td>
								<td><?php echo $session->guest_phone?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td><?php echo $session->guest_email?></td>
							</tr>
						</table>
					</div>

					<?php if( !isset($session->patient_account)) :?>
						<label>No Previous Record</label>
					<?php else:?>
						<a href="<?php echo _route('user:show' , $session->patient_account->user_id) ?>">View Patient Records</a>
					<?php endif?>
				</div>
				<div class="col-md-6">
					<div class="row">
						<?php if($doctor->profile) :?>
						<div class="col-md-2"><img src="<?php echo $doctor->profile?>" style="height: 70px; width: 70px;"></div>
						<?php endif?>
						<div class="col">
							<h2><?php echo isEqual($doctor->gender ,'male') ? 'Dr.':'Dra.'?> <?php echo $doctor->first_name . ' ' .$doctor->last_name?></h2>
							<label>Attending Doctor</label>
						</div>
					</div>
					

					<div class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td>Name</td>
								<td><?php echo $doctor->first_name . ' ' .$doctor->middle_name.' '.$doctor->last_name?></td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><?php echo $doctor->gender?></td>
							</tr>
							<tr>
								<td>Contact Number</td>
								<td><?php echo $doctor->phone_number?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td><?php echo $doctor->email?></td>
							</tr>
						</table>
					</div>
					<a href="<?php echo _route('user:show' , $doctor->id)?>">Show Account</a>
				</div>
			</div>
		</div>

		<div class="card-footer">
			<div class="row">
				<div class="col-md-8">
					<section>
						<h4>Doctors Remarks</h4>
						<p><?php echo $session->remarks?></p>
						<?php if($has_control) :?>
							<a href="#" data-toggle="modal" data-target="#modelDoctorRemarks"><?php echo empty($session->remarks) ? 'Add Remarks' : 'Edit Remarks'?></a>
						<?php endif?>
					</section>

					<?php wDivider(30)?>
						
					</section>
						<h4>Doctors Recommendations</h4>
						<p><?php echo $session->doctor_recommendations?></p>
						<?php if($has_control) :?>
							<a href="#" data-toggle="modal" data-target="#modeldoctorRecommendations"><?php echo empty($session->doctor_recommendations) ? 'Add Recommendations' : 'Edit Recommendations'?></a>
						<?php endif?>
					</section>
				</div>

				<div class="col-md-4">
					<h4>Time Stamps</h4>
					<table class="table table-bordered">
						<tr>
							<td>Date</td>
							<td><?php echo $session->date_created?></td>
						</tr>

						<tr>
							<td>Date Recorded</td>
							<td><?php echo $session->created_at?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>

	<?php wDivider(30)?>


	<div class="card">
		<div class="card-body">
			<section>
				<h4 class="card-title">Files</h4>

				<?php if( isEqual(whoIs('user_type') , 'admin')) :?>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
					  Add File
					</button>
				<?php endif?>
				<hr>

				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<th>#</th>
							<th>Label</th>
							<th>File Name</th>
							<th>Type</th>
							<th>Description</th>
							<th>Action</th>
						</thead>

						<tbody>
							<?php foreach($documents as $key => $row) :?>
								<tr>
									<td><?php echo ++$key?></td>
									<td><?php echo $row->label?></td>
									<td><?php echo $row->filename?></td>
									<td><?php echo $row->file_type?></td>
									<td><?php echo $row->description?></td>
									<td>
										<a href="/ViewerController/show/?file=<?php echo urlencode($row->full_url)?>" class="btn btn-primary btn-sm"> <i class="fa fa-eye"></i> </a>
											&nbsp;

										<a href="<?php echo _download_wrap($row->filename , $row->path) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> </a>
											&nbsp;

										<?php if($has_control) :?>
											<a href="<?php echo _route('attachment:delete' , $row->id) ?>" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </a>
										<?php endif?>
									</td>
								</tr>
							<?php endforeach?>
						</tbody>
					</table>
				</div>
			</section>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<?php echo __($attachment_form->getForm()) ?>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="modelDoctorRemarks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<?php
	      		__([
	      			$form->start(),
	      			$form->addId($session->id)
	      		])
	      	?>

	      	<div class="form-group">
	      		<?php
	      			__( $form->getCol('remarks') );
	      		?>
	      	</div>

	      	<?php __( $form->get('submit') ) ?>

	      	<?php __( $form->end() )?>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="modeldoctorRecommendations" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Doctor Recommendations</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<?php
	      		__([
	      			$form->start(),
	      			$form->addId($session->id)
	      		])
	      	?>

	      	<div class="form-group">
	      		<?php
	      			__( $form->getCol('doctor_recommendations') );
	      		?>
	      	</div>

	      	<?php __( $form->get('submit') ) ?>

	      	<?php __( $form->end() )?>
	      </div>
	    </div>
	  </div>
	</div>


<?php endbuild()?>
<?php loadTo()?>