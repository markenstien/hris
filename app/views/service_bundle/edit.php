<?php build('page-control')?>
	<a href="<?php echo _route('service-bundle:index')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-list fa-sm text-white-50"></i> Back to <?php echo $service_bundle->name?> </a>
<?php endbuild()?>

<?php build('content')?>
	<div class="col-md-7">
		<div class="card">
			<div class="card-header">
				<a href="<?php echo _route('service-bundle:show' , $service_bundle->id)?>">Back</a>
			</div>
			<div class="card-body">

				<?php if( $service_bundle->price_custom != 0) :?>
					<div class="panel">
						<a href="<?php echo _route('service-bundle:removeCustomPrice' , $service_bundle->id)?>">Remove Custom Price</a>
					</div>
				<?php endif?>
				
				<?php __( $form->getForm() )?>
			<div>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>