<?php 

	class AttachmentModel extends Model
	{
		public $table = 'attachments';

		public $_fillables = [
			'label',
			'filename',
			'file_type',
			'display_name',
			'search_key',
			'description',
			'global_key',
			'global_id',
			'path',
			'url',
			'full_path',
			'full_url'
		];


		public function __construct()
		{
			parent::__construct();

			$this->path = PATH_UPLOAD;
			$this->url  = GET_PATH_UPLOAD;

			$this->uploader_helper = new UploaderHelper();
		}

		public function upload_multiple($file_data = [] , $file_name = '') {

			$uploadResponse = upload_multiple($file_name, $this->path);

			if (!empty($uploadResponse['result']['arrNames'])) {
				$uploadedItems = $uploadResponse['result']['arrNames'];
				$oldNames = $uploadResponse['result']['arrNamesOld'];

				foreach($uploadedItems as $key => $row) {

					$fileExt = explode('.', $row);
					$fileExt = end($fileExt);

					$file_data['file_type'] = $fileExt;
					$file_data['path']      = $this->path;
					$file_data['full_path'] = $this->path.DS.$row;
					$file_data['url']       = $this->url;
					$file_data['full_url']  = $this->url.DS.$row;
					$file_data['filename']  = $row;
					$file_data['display_name'] = $oldNames[$key];

					//clean
					$fillable_datas = $this->getFillablesOnly($file_data);
					//upload
					$upload_ok = parent::store($fillable_datas);
				}
			}

			return true;
		}
		/*
		*label , display_name , search_key,
		*description , global_key , global_id
		*/
		public function upload( $file_data = [] , $file_name = '' )
		{

			//get file
			$uploader_instance = $this->uploader_helper;
			$uploader_instance->setFile($file_name);
			$uploader_instance->setPath($this->path);

			try
			{
				$res = $uploader_instance->upload();

				//continue upload
				if($res)
				{
					$path = $uploader_instance->getPath();

					$upload_name = $uploader_instance->getName();
					
					//push-column-after-upload-values
					$file_data['file_type'] = $uploader_instance->getExtension();
					$file_data['path']      = $path ;
					$file_data['full_path'] = $path.DS.$upload_name;
					$file_data['url']       = $this->url;
					$file_data['full_url']  = $this->url.DS.$upload_name;
					$file_data['filename']  = $upload_name;
					$file_data['display_name'] = $file_data['display_name'] ?? $uploader_instance->getNameOld();
					
					//clean
					$fillable_datas = $this->getFillablesOnly($file_data);
					//upload
					$upload_ok = parent::store($fillable_datas);

					if($upload_ok) 
					{
						$this->addMessage("File uploaded!");
						return true;
					}else{
						$this->addError("Something went wrong!");
						return false;
					}
				}

			}catch(Exception $e)
			{
				echo die($e->getMessage());
			}
			
		}	
		

		public function deleteWithFile($id)
		{
			$file = parent::get($id);

			if($file)
			{
				$res = parent::delete($id);
				if($res) {
					unlink($file->full_path);
					$this->addMessage("{$file->filename} has been deleted!");
					return true;
				}else{
					$this->addError("Unable to delete file");
					return false;
				}
			}

			$this->addError("File not found");
			return false;
		}
	}