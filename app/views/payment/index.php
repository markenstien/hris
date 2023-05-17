<?php build('content')?>
	<div class="card">
		<?php Flash::show()?>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered dataTable">
					<thead>
						<th>#</th>
						<th>Reference</th>
						<th>Amount</th>
						<th>Method</th>
						<th>Payer</th>
						<th>External Reference</th>
						<th>ORG</th>
						<th>Bill</th>
						<th>Action</th>
					</thead>

					<tbody>
						<?php foreach( $payments as $key => $row) :?>
							<tr>
								<td><?php echo ++$key?></td>
								<td><?php echo $row->reference?></td>
								<td><?php echo amountHTML($row->amount)?></td>
								<td><?php echo $row->method?></td>
								<td><?php echo $row->acc_name?></td>
								<td><?php echo $row->external_reference?></td>
								<td><?php echo $row->org?></td>
								<td>
									<a href="<?php echo _route('bill:show' , $row->bill_id)?>">Show Bill</a>
								</td>
								<td>
									<?php
										__([
											btnView(_route('payment:show' , $row->id)),
											btnEdit(_route('payment:edit' , $row->id)),
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