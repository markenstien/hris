<?php build('content')?>
	<div class="card">
		<?php Flash::show()?>
		<div class="card-body">
			<?php echo anchor(_route('user:show' , $doctor_id) , 'Back' , 'Back')?>
			<?php echo $form->getForm()?>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>