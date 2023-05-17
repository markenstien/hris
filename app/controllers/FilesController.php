<?php 	

	class FilesController extends Controller
	{

		public function __construct()
		{
			$this->file = model('FileModel');
		}

		/*
		*Files
		*foldername
		*metaId
		*metaKey
		*redirectTo = default referer
		*/

		public function upload()
		{
			$post = request()->posts();


			/*create file in a folder */
			if( isset($post['folder_id']) )
			{
				/*
				*if filename is set then create new folder on top of it
				*this will create a folder on top of the folder
				*/

				if( !empty($post['folder_name']) )
				{
					$folderModel = model('FolderModel');

					$folderId = $folderModel->create([
						'meta_id' => $post['meta_id'],
						'meta_key' => $post['meta_key'],
						'folder'  => $post['folder_name'],
						'parent_id' => $post['folder_id']
					]);
				}else
				{
					$folderId = $post['folder_id'];
				}

				$res = $this->file->uploadWithFolder('files' , [
					'meta_id' => $post['meta_id'],
					'meta_key' => $post['meta_key'],
					'meta_id' => $post['meta_id'],
					'folder_id'  => $folderId
				]);
			}else
			{
				//if you want to upload a files inside a folder
				if( !empty($post['folder_name']) )
				{
					$this->file->uploadWithFolderCreate('files' ,[
						'metaId' => $post['meta_id'],
						'metaKey' => $post['meta_key'],
						'folderName' => $post['folder_name']
					]);

				}else
				{
					/*upload no folder*/
					$this->file->upload('files' , [
						'metaId' => $post['meta_id'],
						'metaKey' => $post['meta_key'],
					]);
				}
				
			}

			Flash::set("Files uploaded");
			return request()->return();
		}


		public function delete($id)
		{
			$this->file->delete($id);
			Flash::set("File Deleted");
			
			return request()->return();
		}

	}