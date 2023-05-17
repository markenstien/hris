<?php 	
	require_once APPROOT.DS.'libraries/spreadsheet/vendor/autoload.php';
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



	class ExcelExport
	{
		/*get the data*/
		public function setData($data)
		{
			$this->data = $data;
		}

		public function getData()
		{
			return $this->data;
		}

		public function setHeader($header)
		{
			$this->header = $header;
		}
		public function setName($name)
		{
			$this->name = $name;
		}

		public function setDescription($desc)
		{
			$this->desc = $desc;
		}
		public function exportFile()
		{
			$this->formatExcel();
		}
		private function formatExcel()
		{

			$data = $this->data;
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
            
		    if(is_array($data))
		    {
		    	$rowCount = 0;
		    	$alphabhet = range('A' , 'Z');

		    	if(isset($this->header))
		    	{
		    		$header = $this->header;

		    		foreach($header as $key=> $h) 
		    		{
		    			$sheet->setCellValue($alphabhet[$key].'1' , $h);
		    		}

		    		$rowCount = 2;
		    		foreach($data as $key => $columns)
			    	{
			    		// $rowCount = 1;
			    		$colCounter = 0;

			    		foreach($columns as $colCount => $col)
			    		{
			    			$sheet->getColumnDimension($alphabhet[$colCounter])
			    			->setAutoSize(true);

			    			$sheet->setCellValue($alphabhet[$colCounter].''.($rowCount) , $col);
			    			
			    			$colCounter++;
			    		}

			    		$rowCount++;
			    	}
		    	}else{
			    	foreach($data as $rowCount => $columns)
			    	{
			    		$colCounter = 0;
			    		foreach($columns as $colCount => $col)
			    		{
			    			$sheet->setCellValue($alphabhet[$colCounter].''.($rowCount+1) , $col);
			    			$colCounter++;
			    		}
			    	}
		    	}

		    	$name = uniqid();

		    	if(isset($this->name) && !empty($this->name)){
		    		$name = $this->name;
		    	}
		    	
		    	$file = $name.'.xlsx';
				$path = BASE_DIR.DS.'public/assets/uploads/office';
				$writer = new Xlsx($spreadsheet);
				try{
					header('Content-Type: application/vnd.ms-excel');
					header('Content-Disposition: attachment; filename="'.$file.'"');
					ob_get_clean();
					$writer->save("php://output");
					Flash::set('Report Generated');
				}catch(Exception $e){
					Flash::set($e->getMessage() , 'danger');
					err_404('Trying to detect error');
				}
		    }else
		    {
		    	var_dump($data);
		    }


		}
	}