<?php 	

	class FileModel extends Model
	{
		public $table = 'files';
		public $path = PATH_UPLOAD;
		public $url  = GET_PATH_UPLOAD;


		public function upload($fileName , $parameters = [])
		{
			$upload = $this->uploadFiles( $fileName );

			if(!$upload)
				return false;
			extract($parameters);

			return $this->saveUploads($upload , $metaId , $metaKey);

		}
		
		public function uploadFiles($fileName)
		{
			$upload = upload_multiple($fileName , $this->path);

			if( !isEqual($upload['status'] , 'success') )
			{
				$this->addError("Upload failed!");
				return false;
			}

			return $upload;
		}

		public function uploadWithFolder($fileName , $parameters = [])
		{
			$upload = $this->uploadFiles( $fileName );

			if(!$upload)
				return false;

			extract($parameters);

			return $this->saveUploads($upload , $meta_id , $meta_key , $folder_id );
		}

		/*
		*uploaded files are from upload_multiple function
		*/
		public function saveUploads( $uploadedFiles , $metaId , $metaKey , $folderId = null)
		{
			
			$uploadResult = $uploadedFiles['result'];

			$pathUploadNames = $uploadResult['arrNames'];

			$oldNames = $uploadResult['arrNamesOld'];

			$path = $this->path;
			$url  = $this->url;

			$sql = "INSERT INTO {$this->table}(
			folder_id , 
			meta_id , 
			meta_key ,
			name,
			display_name,
			path,
			full_path,
			url
			) VALUES";

			$path = str_escape( $path );
			$url = str_escape($url);

			foreach( $pathUploadNames as $key => $name)
			{
				$displayName = str_escape($oldNames[$key]);
				$fullPath = str_escape($this->path.DS.$name);

				

				if( $key > 0)
					$sql .= ",";

				$sql .= "(
				'{$folderId}', 
				'{$metaId}', 
				'{$metaKey}',
				'{$name}',
				'{$displayName}',
				'$path',
				'$fullPath',
				'$url')";
			}

			$this->db->query( $sql );

			$retVal = $this->db->execute();

			return $retVal;
		}

		public function uploadWithFolderCreate($fileName , $parameters = [])
		{
			$folder = model('FolderModel');

			extract($parameters);

			$folderId = $folder->create([
				'meta_id' => $metaId,
				'meta_key' => $metaKey,
				'folder' => $folderName
			]);

			if( !$folderId ){
				$this->addError( $folder->getErrorString() );
				return false;
			}

			$upload = $this->uploadFiles( $fileName );

			if(!$upload)
				return false;

			return $this->saveUploads($upload , $meta_id , $meta_key , $folderId );
		}

		public function getByFolder($folderId)
		{
			$files = parent::getAssoc('display_name' , [
				'folder_id' => $folderId
			]);

			return $files;
		}

		private function folder()
		{
			$folder = model('FolderModel');

			return $folder;
		}

		public function fetchFiles( $where = null)
		{
			$files = parent::getAssoc('display_name' , $where);
			return $files;
		}
	}