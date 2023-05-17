<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title></title>
</head>
<title><?php echo $title?? COMPANY_NAME?></title>

<!-- Custom fonts for this template-->
<link href="<?php echo _path_tmp('vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="<?php echo _path_tmp('css/sb-admin-2.min.css')?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo _path_public('css/main/global.js')?>">
<script type="text/javascript" src="<?php echo _path_public('js/core.js')?>"></script>
<?php produce('headers')?>
<?php produce('styles')?>
<body>

<div class="col-md-5 mx-auto">
	<?php if( isset($results)) :?>
		<?php divider()?>
		<div class="text-center">
			<h4>Vital Care Report</h4>
			<h5>For</h5>
			<p><?php echo "{$filter['start_date']} to {$filter['end_date']}" ?></p>
		</div>
		<table class="table table-bordered">
			<tr>
				<td>Total Appointments</td>
				<td>Total Arrived Appointments</td>
				<td>Total Sessions</td>
				<td>Estimated Revenue</td>
			</tr>
			<tr>
				<td><?php echo $summary['total_appointments'] ?></td>
				<td><?php echo $summary['total_appointment_arrived'] ?></td>
				<td><?php echo $summary['total_sessions'] ?></td>
				<td><?php echo $summary['estimated_revenue'] ?></td>
			</tr>
		</table>

		<?php if( $summary['doctor_total_rendered_sessions'] ) : ?>
			<h4>Doctors Summary</h4>
			<table class="table table-bordered">
				<tr>
					<td>Doctor</td>
					<td>Sessions Processed</td>
				</tr>
				<?php foreach($summary['doctor_total_rendered_sessions'] as $doc_ses) :?>
					<tr>
						<td><?php echo $doc_ses['name']?></td>
						<td><?php echo $doc_ses['total']?></td>
					</tr>
				<?php endforeach?>
			</table>
		<?php endif?>

		<?php if( isset($report_grouped) && $report_grouped ) :?>
			<h4>Daily</h4>
			<section style="border:1px solid #000; padding: 10px;margin-bottom: 15px;">
				<h5>Appointments</h5>
				<?php foreach($report_grouped['appointments'] as $key => $items) :?>
				<table class="table table-bordered">
					<tr>
						<td><?php echo $key?></td>
						<td><?php echo !empty($items) ? count($items) : 'No Appointments'?></td>
					</tr>
				</table>
				<?php endforeach?>
			</section>

			<?php if( $report_grouped['sessions']) :?>
				<section style="border:1px solid #000; padding: 10px;margin-bottom: 15px;">
					<h5>Sessions</h5>
					<?php foreach($report_grouped['sessions'] as $key => $items) :?>
					<table class="table table-bordered">
						<tr>
							<td><?php echo $key?></td>
							<td><?php echo !empty($items) ? count($items) : 'No Appointments'?></td>
						</tr>
					</table>
					<?php endforeach?>
				</section>
			<?php endif?>

			<?php if( $report_grouped['services_catered']) :?>
				<section style="border:1px solid #000; padding: 10px;margin-bottom: 15px;">
					<h5>Services Catered</h5>
					<?php foreach($report_grouped['services_catered'] as $key => $items) :?>
					<table class="table table-bordered">
						<tr>
							<td><?php echo $key?></td>
							<td><?php echo !empty($items) ? count($items) : 'No Appointments'?></td>
						</tr>
					</table>
					<?php endforeach?>
				</section>
			<?php endif?>
		<?php endif?> 

			<?php if( $results['appointments']) :?>
				<h4>Appointments</h4>
				<table class="table table-bordered table-sm">
					<thead>
						<th>Date</th>
						<th>Reference</th>
						<th>Guest Name</th>
					</thead>

					<tbody>
						<?php foreach($results['appointments'] as $row) :?>
							<tr>
								<td><?php echo $row->date?></td>
								<td><?php echo $row->reference?></td>
								<td><?php echo $row->guest_name?></td>
							</tr>
						<?php endforeach?>
					</tbody>
				</table>
			<?php endif?>


			<?php if( $results['sessions']) :?>
				<h4>Sessions</h4>
				<table class="table table-bordered table-sm">
					<thead>
						<th>Date</th>
						<th>Guest Name</th>
					</thead>

					<tbody>
						<?php foreach($results['sessions'] as $row) :?>
							<tr>
								<td><?php echo $row->date_created?></td>
								<td><?php echo $row->guest_name?></td>
								<td><?php echo $row->doctor_name?></td>
							</tr>
						<?php endforeach?>
					</tbody>
				</table>
			<?php endif?>
	<?php endif?>

	<button onclick="window.print()" class="btn btn-primary btn-sm"> Print </button>
	<a href="/ReportController/create" class="btn btn-primary btn-sm">Back</a>
</div>
</body>
</html>