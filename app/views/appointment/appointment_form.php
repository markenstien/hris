<?php build('content')?>
	<div class="container">
		<?php Flash::show()?>
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Appointment Form</h4>
			</div>
			<div class="card-body">
				<?php Flash::show()?>
				<?php if(!$whoIs || isEqual($whoIs->user_type , 'patient')) :?>
					<?php __( [$form->start() ] )?>
						<?php
							if($whoIs){
								$form->add(['type' => 'hidden' , 'value' => $whoIs->id , 'name' => 'user_id']);
								__( $form->get('user_id') );


								$full_name = $whoIs->first_name . ' ' . $whoIs->last_name;
								$email = $whoIs->email;
								$phone_number = $whoIs->phone_number;
							}
							
						?>
						<div class="form-group">
							<?php
								__( $form->getRow('date',['value' => date('Y-m-d') ]));
							?>
						</div>

						<div class="form-group">
							<?php
								__( $form->getRow('start_time',['value' => date('h:i:s', strtotime('+3 hours' .nowMilitary())) ]));
							?>
						</div>

						<div class="form-group">
							<?php
								$form->setValue('guest_name' , $full_name ?? '');
								__( $form->getRow('guest_name'));
							?>
						</div>

						<div class="form-group">
							<?php
								$form->setValue('guest_email' , $email ?? '');
								__( $form->getRow('guest_email'));
							?>
						</div>

						<div class="form-group">
							<?php
								$form->setValue('guest_phone' , $phone_number ?? '');
								__( $form->getRow('guest_phone'));
							?>
						</div>

						<div class="form-group">
							<?php
								$form->setValue('notes' , $phone_number ?? '');
								__( $form->getRow('notes'));
							?>
						</div>

						<div>
							<?php __( $form->get('submit' , ['value' => 'Create Appointment'])) ?>
						</div>

					<?php __( $form->end() )?>

				<?php else:?>
					<?php
						$form->setValue('date' , date('Y-m-d'));
						$form->setValue('type' , 'walk-in');

						__( $form->getForm() );
					?>
				<?php endif?>
			</div>
		</div>	
	</div>
<?php endbuild()?>
<?php loadTo('tmp/base')?>