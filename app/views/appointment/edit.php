<?php build('content')?>
<?php Flash::show()?>
<div class="row">
	<div class="col-md-5">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Appointment Details</h4>
				<p><?php echo $appointment->reference?></p>
			</div>
			<div class="card-body">
				<?php echo $form->getForm()?>
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
<?php loadTo()?>