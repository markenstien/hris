<?php build('content')?>
	<?php if(authType(USER_EMP)) :?>
	<div class="card">
		<div class="card-body">
			<?php if($isLoggedIn) :?>
				<h5>Time In : <span id="last_time_in"><?php echo date('Y-m-d h:i:s A', strtotime($lastLog->time_in))?></span></h5>
				<h5>Duration :<span id="duration"></h5>

				<a href="<?php echo _route('tk:weblog', null, [
					'returnTo' => seal(_route('user:dashboard'))
				])?>" class="btn btn-danger btn-lg">Clock Out</a>    
			<?php else:?>
				<a href="<?php echo _route('tk:weblog', null, [
					'returnTo' => seal(_route('user:dashboard'))
				])?>" class="btn btn-primary btn-lg">Clock In</a>    
			<?php endif?>
		</div>
	</div>
	<?php endif?>

	<?php echo wDivider(40)?>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Certification and Training Program</h4>
		</div>

		<div class="card-body">
			<p>Click the traning to apply</p>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<th>#</th>
						<th>Training and Cert</th>
						<th>Deadline</th>
					</thead>

					<tbody>
						<?php foreach($trainings as $key => $row) : ?>
						<tr>
							<td><?php echo ++$key?></td>
							<td><?php echo wLinkDefault(_route('requirement:show', $row->id), $row->req_title . " - ({$row->req_code})")?></td>
							<td><?php echo $row->end_date?></td>
						</tr>
						<?php endforeach?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php endbuild()?>

<?php build('headers')?>
	<link href="<?php echo _path_tmp('assets/css/scrollspyNav.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo _path_tmp('assets/css/components/tabs-accordian/custom-tabs.css')?>" rel="stylesheet" type="text/css" />
<?php endbuild()?>

<?php build('scripts')?>
	<script defer>
		$(document).ready(function(){
			let seconds =  0;
			let timeIn = $("#last_time_in");
			let screenTimeInMinutes = parseInt(dateDifferenceInMinutes(timeIn.html()));

			setInterval(function() 
			{   
				if(seconds >= 60) {
					screenTimeInMinutes += 1;
					seconds = 0
				}
				seconds++;

				screenTimeInHours = minutesToHours(screenTimeInMinutes);

				$("#duration").html(screenTimeInHours);
			}, 1000);
		});
	</script>
<?php endbuild()?>
<?php loadTo()?>