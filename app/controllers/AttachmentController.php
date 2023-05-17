<?php 
	class AttachmentController extends Controller
	{	

		public function __construct()
		{
			parent::__construct();

			$this->model = model('AttachmentModel');
		}

		public function create()
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->model->upload($post , 'file');

				Flash::set( $this->model->getMessageString());

				if(!$res)
					Flash::set( $this->model->getErrorString() );

				return request()->return();
			}
		}

		public function download()
		{
			if(isset($_GET['filename'] , $_GET['path']))
            {

                $filename = trim($_GET['filename']);
                $path     = _download_unwrap($_GET['path']);
                $file     = $path.DS.$filename;

                $fileExt = explode('.', $filename);
                $fileExt = end($fileExt);

                $fileNameArr = explode('.' , $filename);

                $filename = current($fileNameArr);
                
                if (file_exists($file)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="'.basename($filename.'.'.$fileExt).'"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                }
                
            }
		}

		public function destroy($id)
		{
			$route = $_GET['route'] ?? null;

			$res = $this->model->deleteWithFile($id);

			Flash::set( $this->model->getMessageString() );

			if(!$res)
				Flash::set($this->model->getErrorString() , 'danger');


			if( !is_null($route) )
				return redirect( unseal($route) ); 
			return request()->return();
		}
	}