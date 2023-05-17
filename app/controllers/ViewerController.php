<?php

	class ViewerController extends Controller
	{
		public function show()
		{
			$file = request()->input('file');

			
			return $this->view('viewer/show' , [
				'file' => $file
			]);
		}
	}