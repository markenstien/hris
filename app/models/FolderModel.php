<?php

	class FolderModel extends Model
	{
		public $table = 'folders';


		public function create( $folderData )
		{	

			extract($folderData);

			$isExist = $this->searchFolder( $folder , $meta_id , $meta_key );

			if($isExist){
				$this->addError("Folder '{$folderData['folder']}' already exists ");
				return false;
			}

			return parent::store($folderData);
		}

		public function searchFolder( $folderName , $metaId , $metaKey)
		{
			$folderName = str_replace(" " ,"_" , $folderName);

			return parent::single([
				'folder' => $folderName,
				'meta_id' => $metaId,
				'meta_key' => $metaKey
			]);
		}


		public function get($folderId)
		{
			$file = model('FileModel');

			$folder = parent::get( $folderId );

			$files = $file->getByFolder( $folderId );

			$folders = $this->fetchWithFiles([
				'parent_id' => $folderId
			]);

			$folder->files = $files;
			$folder->folders = $folders;

			return $folder;
		}

		public function fetchWithFiles($where = null)
		{
			$folders = parent::getAssoc('folder' , $where );

			if(!$folders)
				return $folders;

			$file = model('FileModel');
			foreach($folders as $key => $folder)
			{
				$folder->files = $file->getByFolder( $folder->id );
			}

			return $folders;
		}

		public function delete($id)
		{
			$folder = parent::get($id);

			if(!$folder){
				$this->addError("Folder does not exist folder remove failed!");
				return false;
			}

			parent::delete($id);

			$this->addMessage( "Folder {$folder->folder} has been removed!");
			
			return true;
		}
	}