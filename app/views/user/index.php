<?php build('page-control')?>
	<div class="widget widget-content-area page-command-container">
		<a href="<?php echo _route('user:create')?>" 
			class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i data-feather="user-plus"></i></a>
	</div>
<?php endbuild()?>

<?php build('content')?>
	<div class="card">
		<?php Flash::show()?>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered dataTable">
					<thead>
						<th>#</th>
						<th>Ref</th>
						<th>Name</th>
						<th>Email</th>
						<th>Type</th>
						<th>Action</th>
					</thead>

					<tbody>
						<?php foreach($users as $key => $row) :?>
							<tr>
								<td><?php echo ++$key?></td>
								<td><?php echo $row->user_code?></td>
								<td><?php echo $row->first_name . ' ' .$row->last_name?></td>
								<td><?php echo $row->email?></td>
								<td><?php echo $row->user_type?></td>
								<td>
									<?php
										__([
											btnView(_route('user:show' , $row->id)),
											btnEdit(_route('user:edit' , $row->id))
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