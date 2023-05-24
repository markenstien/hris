<?php build('content')?>
	<div class="container">
		<div class="col-md-7 mx-auto">
			<?php Flash::show()?>
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Login-Form</h4>

					<a href="<?php echo _route('appointment:appointment_form')?>">Create Appointment</a>
				</div>
				<div class="card-body">
					<?php 
						__( $form->start() );
					?>

					<div class="form-group">
						<?php
							__( $form->getCol('email') );
						?>
					</div>
					<div class="form-group">
						<?php
							__( $form->getCol('password') );
						?>
					</div>

					<div>
						<?php __($form->get('submit')) ?>
					</div>
					<?php __( $form->end() )?>
				</div>
			</div>
		</div>
	</div>
<?php endbuild()?>

<?php build('styles')?>
	<style type="text/css">
		div.bordered-form-element
		{
			border: 1px solid #000;
			margin-bottom: 2px;
			padding: 5px;
		}
	</style>
<?php endbuild()?>
<?php loadTo('tmp/base')?>