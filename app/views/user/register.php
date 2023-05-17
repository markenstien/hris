<?php build('page-control')?>
	<a href="<?php echo _route('user:index')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-users fa-sm text-white-50"></i> Users </a>
<?php endbuild()?>


<?php build('content')?>
	<div class="col-md-7 mx-auto">
		<?php Flash::show()?>
		<?php __( $form->start() )?>
			<div class="row">
				<div class="col-md-7">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Personal</h4>
						</div>
						<div class="card-body">
							<?php if($backerData) :?>
								<?php 
									__($form->getRow('backer_name')); 
									__($form->getRow('backer_id')); 
								?>
							<?php else:?>
								<?php
									__($form->getRow('backer_user_code'));
								?>
							<?php endif?>

							<div class="form-group">
								<?php
									__( $form->getRow('profile') );
								?>
							</div>
							

							<div class="form-group">
								<?php
									__( $form->getRow('first_name') );
								?>
							</div>

							<div class="form-group">
								<?php
									__( $form->getRow('middle_name') );
								?>
							</div>


							<div class="form-group">
								<?php
									__( $form->getRow('last_name') );
								?>
							</div>

							<div class="form-group">
								<?php
									__( $form->getRow('birthdate') );
								?>
							</div>

							<div class="form-group">
								<?php
									__( $form->getRow('gender') );
								?>
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Contact</h4>
						</div>
						<div class="card-body">
							<div class="form-group">
								<?php
									__( $form->getRow('email') );
								?>
							</div>

							<div class="form-group">
								<?php
									__( $form->getRow('phone_number') );
								?>
							</div>
						</div>
					</div>

					<!-- <div class="card">
						<div class="card-header">
							<h4 class="card-title">Address</h4>
						</div>

						<div class="card-body">
							<div class="form-group">
								<?php //echo __( $form_address->getFormItems('col') )?>
							</div>
						</div>
					</div> -->
				</div>

				<div class="col-md-5">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Auth</h4>
						</div>

						<div class="card-body">
							<div class="form-group">
								<?php __( $form->getRow('user_type' , [
									'input' => [
										'attributes' => [
											'data-target' => '#id_container_licensed_number'
										]
									]
								]) )?>
							</div>

							<div class="form-group">
								<?php
									__( $form->getRow('password') );
								?>
							</div>

							<div>
								
								<?php __( $form->get('submit' , ['value' => 'Save']) )?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php __( $form->end() )?>
	</div>
<?php endbuild()?>
<?php loadTo('tmp/base')?>