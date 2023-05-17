<?php build('content')?>
	<div class="card">
		<?php Flash::show()?>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered dataTable">
					<thead>
						<th>#</th>
						<th>Reference</th>
						<th>Payer</th>
						<th>Email</th>
						<th>Amount</th>
						<th>Method</th>
						<th>Status</th>
						<th>Action</th>
					</thead>

					<tbody>
						<?php foreach( $bills as $key => $row) :?>
							<tr>
								<td><?php echo ++$key?></td>
								<td><?php echo $row->reference?></td>
								<td><?php echo $row->bill_to_name?></td>
								<td><?php echo $row->bill_to_email?></td>
								<td><?php echo amountHTML($row->total_amount)?></td>
								<td><?php echo $row->payment_method?></td>
								<td><?php echo $row->payment_status?></td>
								<td>
									<?php
										__([
											btnView(_route('bill:show' , $row->id)),
											btnEdit(_route('bill:edit' , $row->id)),
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