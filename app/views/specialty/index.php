<?php build('page-control')?>
<a href="<?php echo _route('specialty:create')?>" 
	class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
class="fas fa-list fa-sm text-white-50"></i> Add Specialties </a>
<?php endbuild()?>
<?php build('content')?>
<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered dataTable">
				<thead>
					<th>#</th>
					<th>Name</th>
					<th>Description</th>
					<th>Category</th>
					<th>Action</th>
				</thead>

				<tbody>
					<?php foreach($specialties as $key => $row) : ?>
						<tr>
							<td><?php echo ++$key?></td>
							<td><?php echo $row->name?></td>
							<td><?php echo $row->description?></td>
							<td><?php echo $row->category?></td>
							<td>
								<?php
									__([
										btnEdit( _route('specialty:edit' , $row->id) ),
										btnDelete( _route('specialty:delete' , $row->id) ),
									])
								?>
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