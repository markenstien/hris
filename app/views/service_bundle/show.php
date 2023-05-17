<?php build('page-control')?>
	<a href="<?php echo _route('category:create')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Add Category</a>
<?php endbuild()?>

<?php build('content')?>
	
	<div class="card">
		<div class="row">
			<div class="col">
				<div class="card-body">
					<h4 class="card-title">Details</h4>
					<div class="table">
						 <table class="table table-bordered">
						 	<thead>
						 		<th>Code</th>
						 		<th>Name</th>
						 		<th>Price</th>
						 		<th>Discount</th>
						 		<th>Description</th>
						 	</thead>

						 	<tbody>
						 		<tr>
						 			<td><?php echo $service_bundle->code?></td>
						 			<td><?php echo $service_bundle->name?></td>
						 			<td><?php echo amountHTML($service_bundle->public_price)?></td>
						 			<td><?php echo $service_bundle->discount?></td>
						 			<td><?php echo $service_bundle->description?></td>
						 		</tr>
						 	</tbody>
						 </table>
					</div>
					<a href="<?php echo _route('service-bundle-item:add' , $service_bundle->id)?>">Add Items</a>
					<a href="<?php echo _route('service-bundle:edit' , $service_bundle->id)?>">Edit</a>
				</div>
			</div>

			<div class="col">
				<div class="card-body">
					<h4 class="card-title">Categories</h4>
					<?php foreach($services as $key => $row) :?>
						<a href="#"><span class="badge badge-primary">#<?php echo $row->category?></span></a>
					<?php endforeach?>
				</div>
			</div>
		</div>
		
	</div>

	<?php divider()?>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Items</h4>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered dataTable">
					<thead>
						<th>#</th>
						<th>Ref</th>
						<th>Service</th>
						<th>Price</th>
						<th>Category</th>
						<th>Descriotion</th>
						<th>Status</th>
						<th>Action</th>
					</thead>

					<tbody>
						<?php $total = 0?>
						<?php foreach($services as $key => $row) :?>
							<?php $total += $row->price?>
							<tr>
								<td><?php echo ++$key?></td>
								<td><?php echo $row->code?></td>
								<td><?php echo $row->service?></td>
								<td><?php echo amountHTML($row->price)?></td>
								<td><?php echo $row->category?></td>
								<td><?php echo $row->description?></td>
								<td><?php echo $row->status?></td>
								<td>
									<?php
										__([
											btnDelete(_route('service-bundle-item:delete' , $row->id))
										])
									?>
								</td>
							</tr>
						<?php endforeach?>
					</tbody>
				</table>
			</div>
			<h5>Total Services Amount : <?php echo amountHTML($service_bundle->public_price)?></h5>

			<?php if( $service_bundle->discount ) :?>
			<h5>Total Discounted Amount : <?php echo amountHTML($service_bundle->public_price - $service_bundle->discount)?></h5>
			<?php endif?>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>