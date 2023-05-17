<?php build('content') ?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Product View</h4>
		</div>

		<div class="card-body">
			<div class="row">
				<div class="col-md-7">
					<h4>Product Detail</h4>
					<div class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td width="10%">CODE</td>
								<td>#<?php echo $service->code?></td>
							</tr>
							<tr>
								<td width="30%"><?php echo $_form->getLabel('service')?></td>
								<td><?php echo $_form->getValue('service')?></td>
							</tr>

							<tr>
								<td><?php echo $_form->getLabel('price')?></td>
								<td><?php echo $_form->getValue('price')?></td>
							</tr>

							<tr>
								<td><?php echo $_form->getLabel('description')?></td>
								<td><?php echo $_form->getValue('description')?></td>
							</tr>

							<tr>
								<td>Category</td>
								<td><?php echo $service->category?></td>
							</tr>


							<tr>
								<td>Stocks</td>
								<td><?php echo $service->total_stock?></td>
							</tr>

							<tr>
								<td>Action</td>
								<td><?php echo wLinkDefault(_route('service:edit', $service->id),'Edit Product')?></td>
							</tr>
						</table>
					</div>	
				</div>

				<div class="col-md-5">
					<h4>Images</h4>
					<div class="mt-3 mb-5">
						<?php echo $_attachmentForm->getForm(); ?>
					</div>
					<?php if($images) :?>
						<div  class="row">
						<?php foreach($images as $key => $row) :?>
							<div class="col-md-3">
								<img src="<?php echo $row->full_url?>" style="width: 100%; height: 150px;">
								<?php echo wLinkDefault(_route('attachment:delete', $row->id, [
									'route' => seal(_route('service:show', $service->id))
								]), ' Delete ')?>
								<p><?php echo $row->label?></p>
							</div>
						<?php endforeach?>
						</div>
					<?php endif?>
				</div>
			</div>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>