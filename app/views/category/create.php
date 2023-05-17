<?php build('page-control')?>
	<a href="<?php echo _route('category:index')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-list fa-sm text-white-50"></i> Categories </a>
<?php endbuild()?>

<?php build('content')?>
<?php Flash::show()?>
<div class="col-md-7">
	<div class="card">
		<div class="card-body">
			<?php __( $form->start() )?>
				<div class="form-group">
					<?php __( $form->getRow('category') )?>
				</div>
				<div class="form-group">
					<?php __( $form->getRow('cat_key') )?>
				</div>
				<div>
					<?php __( $form->get('submit') )?>
				</div>
			<?php __( $form->end() )?>
		</div>	
	</div>
</div>
<?php endbuild()?>
<?php loadTo()?>