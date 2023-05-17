<?php build('page-control')?>
	<a href="<?php echo _route('category:index')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-list fa-sm text-white-50"></i> Categories </a>
<?php endbuild()?>

<?php build('content')?>
<?php Flash::show()?>
<div class="card">
	<div class="card-body">
		<?php __( $form->getForm() )?>
	</div>
</div>
<?php endbuild()?>
<?php loadTo()?>