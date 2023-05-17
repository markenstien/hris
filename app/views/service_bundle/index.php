<?php build('page-control')?>
	<a href="<?php echo _route('service-bundle:create')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Add Package </a>
<?php endbuild()?>

<?php build('content')?>
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered dataTable">
					<thead>
						<th>#</th>
						<th>Code</th>
						<th>Name</th>
						<th>Price</th>
						<th>Discount</th>
						<th>Description</th>
						<th>Status</th>
						<th>Action</th>
					</thead>

					<tbody>
						<?php foreach($service_bundles as $key => $row) :?>
							<tr>
								<td><?php echo ++$key?></td>
								<td><?php echo $row->code?></td>
								<td><?php echo $row->name?></td>
								<td><?php echo amountHTML($row->public_price)?></td>
								<td><?php echo $row->discount?></td>
								<td><?php echo $row->description?></td>
								<td><?php echo $row->status?></td>
								<td>
									<?php
										__([
											btnView(_route('service-bundle:show' , $row->id)),
											btnEdit(_route('service-bundle:edit' , $row->id)),
											btnDelete(_route('service-bundle:delete' , $row->id))
										]);
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