<?php build('page-control')?>
	<a href="<?php echo _route('service-bundle:index')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-list fa-sm text-white-50"></i> Service Bundles </a>
<?php endbuild()?>

<?php build('content')?>
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Select Services to bundle</h4>
				</div>
				<div class="card-body">
					<!-- FILTER -->
					<section>
						<?php
							Form::open([
								'method' => 'GET',
								'action' => ''
							]);
						?>

						<div class="form-group">
							<?php
								Form::label('Keyword Search');
								Form::text('key_word' , '' , [
									'class' => 'form-control'
								])
							?>
						</div>

						<?php
							$filter_categories = $_GET['categories'] ?? [];
						?>
						<?php foreach($categories as $category) :?>
							<label style="padding: 10px; background: #eee;">
								<?php echo strtoupper($category->category)?>
								<?php 
									$category_is_check = isEqual( $category->id, $filter_categories);

									Form::checkbox('categories[]', $category->id , $category_is_check ? [
										'checked' => true
									] : null);
								?>
							</label>
						<?php endforeach?>

						<div class="mt-2">
							<?php Form::submit('btn_filter' , 'Apply Filter')?>
							<?php if( isset($_GET['btn_filter']) || isset($_GET['category'])) :?>
								<a href="?" class="btn btn-warning btn-sm"> Clear Filter </a>
							<?php endif?>
						</div>
						<?php Form::close()?>

					</section>

					<br>
					<!--//FILTER -->
					<div class="row">
					<?php foreach($services as $row) :?>	
						<div class="col-md-4 mb-2">
							<div class="card">
								<div class="card-body">
									<p><?php echo $row->description?></p>
								</div>
								<div class="card-footer">
									<h6><?php echo $row->service?></h6>
									<div><a href="#"><small><?php echo $row->code?></small></a></div>
									<br>
									<label>PHP : <?php echo amountHTML($row->price ?? 0)?></label>

									<?php
										Form::open([
											'method' => 'post',
											'action' => _route('service-bundle-item:add' , $bundle_id)
										]);

										Form::hidden('service_id' , $row->id);
										Form::hidden('bundle_id' , $bundle_id);


										Form::submit('' , 'Add' , [
											'class' => 'btn btn-primary'
										]);
									?>

									<?php Form::close()?>
								</div>
							</div>
						</div>
					<?php endforeach?>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Items</h4>
				</div>
				<div class="card-body">
					<table class="table table-bordered">
						<?php foreach($bundle_items as $row) :?>
							<tr>
								<td>
									<a href="#"><?php echo $row->code?></a>
								</td>
								<td><a href="<?php echo _route('service-bundle-item:delete' , $row->id)?>">Delete</a></td>
							</tr>
						<?php endforeach?>
					</table>
				</div>
			</div>

			<div class="card mt-2">
				<div class="card-header">
					<h4 class="card-title">General</h4>

					<a href="<?php echo _route('service-bundle:show' , $bundle->id)?>">Back to Overview</a>
				</div>
				<div class="card-body">
					<table class="table table-bordered">
						<tr>
							<td>Bundle Name</td>
							<td><?php echo $bundle->name?></td>
						</tr>
						<tr>
							<td>Code</td>
							<td><?php echo $bundle->code?></td>
						</tr>
						<tr>
							<td>Price</td>
							<td><?php echo $bundle->public_price?></td>
						</tr>
						<tr>
							<td>Description</td>
							<td><?php echo $bundle->description?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>