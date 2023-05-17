<?php 

	class ReportController extends Controller
	{	

		public function __construct()
		{

			$this->model = model('ReportModel');
		}

		public function create()
		{	

			$data = [];

			if( isset($_GET['report_create']) )
			{

				$results = $this->model->createReport( $_GET );
				$summary = $this->model->summarizeResults($results);


				$sessions = $results['sessions'];
				$appointments = $results['appointments'];
				$services_catered = $results['services_catered'];


				if( !empty($_GET['report_type']) )
				{
					$report_type = $_GET['report_type'];

					$report_grouped  = [
						'sessions' => $this->model->groupResults($sessions , $report_type, 'date_created'),
						'appointments' => $this->model->groupResults($appointments , $report_type , 'date'),
						'services_catered' => $this->model->groupResults($services_catered , $report_type , 'created_at'),
					];
				}
				

				$data = [
					'title' => 'Create Report',
					'results' => $results,
					'summary' => $summary,
					'filter'  => $_GET
				];

				if( isset($report_grouped) )
					$data['report_grouped'] = $report_grouped;
			}

			if( isset($data['results']) ){
				return $this->view('report/index_skeleton' , $data);
			}
			
			return $this->view('report/index' , $data);
		}

		public function createReports()
		{

		}
	}