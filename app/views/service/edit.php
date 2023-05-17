<?php build('page-control')?>
	<a href="<?php echo _route('service:index')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-list fa-sm text-white-50"></i> Products </a>
<?php endbuild()?>

<?php build('content')?>	
	<div class="col-md-7">
		<?php Flash::show()?>
		
		<div class="card">
			<div class="card-body">
				<?php echo $form->getForm()?>
			</div>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>