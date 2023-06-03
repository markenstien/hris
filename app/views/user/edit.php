<?php build('content')?>
<div class="col-md-8 mx-auto">
	<?php Flash::show()?>
	<?php __( $form->start() )?>
	<?php __($employmentForm->getRow('employment_detail_id')) ?>
	<div class="statbox widget box box-shadow">
		<div class="widget-header">
			<div class="row">
				<div class="col-xl-12 col-md-12 col-sm-12 col-12">
					<h4>Personal Information</h4>
					<?php echo wLinkDefault(_route('user:show', $user->id),'', [
						'icon' => 'arrow-left-circle'
					])?>
				</div>
			</div>
		</div>

		<div class="widget-content widget-content-area">
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<?php if(!empty($user->profile)) :?>
							<img src="<?php echo $user->profile?>" alt="" width="180px">
						<?php endif?>
					</div>
					<div class="col-md-8">
						<label for="#">Update profile picture</label>
						<?php __($form->getCol('profile'))?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4"><?php __($form->getCol('first_name')); ?></div>
					<div class="col-md-4"><?php __($form->getCol('middle_name')); ?></div>
					<div class="col-md-4"><?php __($form->getCol('last_name')); ?></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4"><?php __($form->getCol('gender')); ?></div>
					<div class="col-md-4"><?php __($form->getCol('birthdate')); ?></div>
					<div class="col-md-4"><?php __($form->getCol('place_of_birth')); ?></div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><?php __($form->getCol('civil_status')); ?></div>
					<div class="col-md-6"><?php __($form->getCol('religion')); ?></div>
				</div>
			</div>
		</div>
		
		<div class="widget-content widget-content-area">
			<h4>Contact</h4>
			<div class="form-group">
				<div class="row">
					
					<div class="col-md-4"><?php __($form->getCol('phone_number')); ?></div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-md-8"><?php __($form->getCol('address'));?></div>
				</div>
			</div>
		</div>
		<?php if(isEqual($user->user_type, 'employee') && isManagement()) :?>
		<div class="widget-content widget-content-area">
			<h4>Work Details</h4>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><?php __($employmentForm->getCol('salary_per_month'))?></div>
					<div class="col-md-6"><?php __($employmentForm->getCol('employment_date'))?></div>
				</div>
			</div>
		</div>
		<?php endif?>

		<div class="widget-content widget-content-area">
			<h4>Credentials</h4>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4"><?php __($form->getCol('email')); ?></div>
					<div class="col-md-4"><?php __($form->getCol('password'));?></div>
				</div>
			</div>
			<div class="form-group"><?php __( $form->get('submit' , ['value' => 'Save']) )?></div>
		</div>
	</div>
	<?php __( $form->end() )?>
</div>
<?php endbuild()?>
	<?php build('scripts')?>
		<script type="text/javascript" src="<?php echo _path_public('js/user-logic.js')?>"></script>
	<?php endbuild()?>
<?php loadTo()?>