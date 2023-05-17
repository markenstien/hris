<?php build('page-control')?>
	<a href="<?php echo _route('category:create')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Add Category</a>
<?php endbuild()?>

<?php build('content')?>
	
	<div class="card">
		<div class="card-body"></div>
	</div>
<?php endbuild()?>
<?php loadTo()?>