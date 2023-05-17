<?php 

	class ReportModel extends Model
	{

		public function __construct()
		{
			parent::__construct();


			$this->appointment_model = model('AppointmentModel');
			$this->session_model = model('SessionModel');
			$this->bill_item_model = model('BillItemModel');
		}

		public function createReport( $filter = [] )
		{
			/**
			 * Appointments
			 */

			$where = [
				'date' => [
					'condition' => 'between',
					'value' => [$filter['start_date'] , $filter['end_date']]
				]
			];

			$appointments = $this->appointment_model->getAssoc('id' , $this->conditionConvert($where));

			$session_reports = $this->session_model->getAll([
				'where' => [
					'date_created' => [
						'condition' => 'between',
						'value'     => [$filter['start_date'] , $filter['end_date']]
					]
				]
			]);

			$services_catered = $this->bill_item_model->getByDate( $filter['start_date'] , $filter['end_date'] );

			return [
				'sessions' => $session_reports,
				'appointments'    => $appointments,
				'services_catered' => $services_catered
			];
		}

		public function groupResults($report_results , $type , $column )
		{
			$process_items = null;
			if(!$report_results)
				return false;

			switch(strtolower($type))
			{
				case 'daily':
					$prev_date = null;
					foreach($report_results as $item) 
					{
						$date = $item->$column;
						if( is_null($process_items) ){
							$process_items[$date] = [];
							$prev_date = $date;
						}
						if( $prev_date != $date )
							$prev_date = $date;
						$process_items[$prev_date][] = $item;
					}			
				break;

				case 'monthly':
					$prev_date = null;
					foreach($report_results as $item) 
					{
						$date = $item->$column;

						$month = date('F' , strtotime($date));

						if( is_null($process_items) ){
							$process_items[$month] = [];
							$prev_date = $date;
						}

						if( date('m' , strtotime($prev_date)) != date('m' , strtotime($date)) )
							$prev_date = $date;
						$process_items[$month][] = $item;
					}			
				break;

				case 'yearly':
					$prev_date = null;
					foreach($report_results as $item) 
					{
						$date = $item->$column;

						$year = date('Y' , strtotime($date));
						if( is_null($process_items) ){
							$process_items[$year] = [];
							$prev_date = $date;
						}
						if( date('y' , strtotime($prev_date)) != date('y' , strtotime($date)) )
							$prev_date = $date;
						$process_items[$year][] = $item;
					}			
				break;
			}

			return $process_items;
		}

		public function summarizeResults( $report_results )
		{
			$appointments = $report_results['appointments'];
			$sessions = $report_results['sessions'];
			$services_catered = $report_results['services_catered'];
			
			$report_summary = [
				'total_appointments' => 0,
				'total_appointment_arrived' => 0,
				'total_sessions' => 0,
				'estimated_revenue' => 0,
				'doctor_total_rendered_sessions' => []
			];

			if($appointments)
			{
				$report_summary['total_appointments'] = count($appointments);

				foreach($appointments as $key => $row) 
				{
					if(isEqual($row->status , 'arrived'))
						$report_summary['total_appointment_arrived']++;
				}
			}

			if( $sessions )
			{
				$report_summary['total_sessions'] = count($sessions);

				foreach($sessions as $row) 
				{
					if( !isset($report_summary['doctor_total_rendered_sessions'][$row->doctor_id]) ){
						$report_summary['doctor_total_rendered_sessions'][$row->doctor_id] = [
							'name'  => $row->doctor_name,
							'total' => 0
						];
					}

					$report_summary['doctor_total_rendered_sessions'][$row->doctor_id]['total']++;
				}
			}
			
			if( $services_catered ){
				foreach($services_catered as $key => $row ){
					$report_summary['estimated_revenue'] += $row->price;
				}
			}

			return $report_summary;	
		}
	}