<?php build('page-control')?>
	<a href="<?php echo _route('specialty:index')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Specialties </a>
<?php endbuild()?>

<?php build('content')?>
<div class="col-md-7">
	<div class="card">
		<div class="card-body">
			<?php __( $form->start() )?>
				<div class="form-group">
					<?php __( $form->getRow('name') ) ?> 
				</div>
				<div class="form-group">
					<?php __( $form->getRow('description') ) ?> 
				</div>
				<div class="form-group">
					<?php __( $form->getRow('category_id') ) ?> 
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