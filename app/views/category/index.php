<?php build('page-control')?>
	<a href="<?php echo _route('category:create')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Add Category</a>
<?php endbuild()?>

<?php build('content')?>
<?php Flash::show()?>
<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered dataTable	">
				<thead>
					<th>#</th>
					<th>Category</th>
					<th>Category Key</th>
					<th>Action</th>
				</thead>

				<tbody>
					<?php foreach( $categories as $key => $row) : ?>
						<tr>
							<td><?php echo ++$key?></td>
							<td><?php echo strtoupper($row->category)?></td>
							<td><?php echo $row->cat_key?></td>
							<td>
								<?php __([
									btnEdit(_route('category:edit' , $row->id)),
									btnDelete(_route('category:delete' , $row->id))
								])?>
							</td>
						</tr>
					<?php endforeach?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php endbuild()?>
<?php loadTo()?>