<?php build('content')?>
	<div class="container">
		<?php Flash::show()?>
		<div class="row">
			<div class="col-md-3">
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
					<div class="bordered-form-element">
						<label>
							<?php echo strtoupper($category->category)?>
							<?php 
								$category_is_check = isEqual( $category->id, $filter_categories);

								Form::checkbox('categories[]', $category->id , $category_is_check ? [
									'checked' => true
								] : null);
							?>
						</label>
					</div>
				<?php endforeach?>

				<div class="mt-2">
					<?php Form::submit('btn_filter' , 'Apply Filter')?>
					<?php if( isset($_GET['btn_filter']) || isset($_GET['category'])) :?>
						<a href="?" class="btn btn-warning btn-sm"> Clear Filter </a>
					<?php endif?>
				</div>
				<?php Form::close()?>

			</div>

			<div class="col-md-6">
				<div class="row">
					<?php foreach($service_bundles as $row) :?>
						<?php $categories_selected = [] ?>
						<div class="col-md-6 mb-3">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"><?php echo $row->name?></h4>
								</div>
								<div class="card-body">
									<table class="table table-bordered">
										<tr>
											<td>Price</td>
											<td><?php echo $row->public_price?></td>
										</tr>
									</table>
									<?php if( $row->items ) :?>
										<div>
											Category : 
											<?php foreach($row->items as $item_key => $item) : ?>
												<?php
													if( isEqual( $item->category , $categories_selected ) ){
														continue;
													}
													$categories_selected[] = $item->category
												?>
												<a href="?category=<?php echo $item->category?>">
													<label class="badge badge-primary"><?php echo $item->category?></label>
												</a>
											<?php endforeach?>
										</div>
									<?php endif?>
								</div>

								<div class="card-footer">
									<?php
										Form::open([
											'method' => 'post',
											'action' => _route('service-cart:add')
										]);
										Form::hidden('service_id' , $row->id);
										Form::hidden('type' , 'bundle');

										if( auth() ){
											Form::hidden('user_id' , auth('id'));
										}else{
											Form::hidden('session_token' , $service_cart_model->getAndCreateToken());
										}
									?>
									<?php Form::submit('' , 'Select Bundle');?>
									<div class="mt-2">
										<a href="<?php echo _route('service-bundle:show' , $row->id)?>">
											Show Bundle
										</a>
									</div>
									<?php Form::close();?>
								</div>
							</div>
						</div>
					<?php endforeach?>

					<?php foreach( $services as $row) :?>
						<div class="col-md-6 mb-3">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"><?php echo $row->service?></h4>
								</div>
								<div class="card-body">
									<table class="table table-bordered">
										<tr>
											<td>Price</td>
											<td><?php echo $row->price?></td>
										</tr>
									</table>
									<div>Category : 
										<a href="?category=<?php echo $row->category?>">
											<label class="badge badge-primary"><?php echo $row->category?></label>
										</a>
									</div>
								</div>

								<div class="card-footer">
									<?php
										Form::open([
											'method' => 'post',
											'action' => _route('service-cart:add')
										]);
										Form::hidden('service_id' , $row->id);
										Form::hidden('type' , 'single');

										if( auth() ){
											Form::hidden('user_id' , auth('id'));
										}else{
											Form::hidden('session_token' , $service_cart_model->getAndCreateToken());
										}
										
										Form::submit('' , 'Select service');

										Form::close();
									?>
								</div>
							</div>
						</div>
					<?php endforeach?>
				</div>
			</div>

			<div class="col-md-3">
				<div>
					<h4> <i class="fas fa-shopping-cart"></i> Services Selected <?php echo $cart_summary['total_items']?></h4>
					<div>Total : <?php echo $cart_summary['total_amount']?></div>
					<a href="<?php echo _route('service-cart:show' , $service_cart_model->getAndCreateToken())?>">Go to Appointment Reservation</a>
					<br> <br>
					<?php if( intval($cart_summary['total_items']) > 0) :?>
						<a href="<?php echo _route('service-cart:destroy-cart')?>" class="btn btn-danger btn-sm">Clear Cart</a>
					<?php endif?>
				</div>
			</div>
		</div>
	</div>
<?php endbuild()?>

<?php build('styles')?>
	<style type="text/css">
		div.bordered-form-element
		{
			border: 1px solid #000;
			margin-bottom: 2px;
			padding: 5px;
		}
	</style>
<?php endbuild()?>
<?php loadTo('tmp/base')?>