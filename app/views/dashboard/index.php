<?php build('content')?>
	
	<div class="card">
		<div class="card-body">
			<h4><?php echo whoIs('first_name') . ' '.whoIs('last_name')?></h4>
			<p>#<?php echo whoIs('user_code')?> - <?php echo whoIs('position_name')?></p>
		</div>

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