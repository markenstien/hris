<?php 

	class FolderController extends Controller
	{

		public function __construct()
		{
			$this->folder = model('FolderModel');
		}

		public function create()
		{
			$post = request()->posts();

			$this->folder->store([
				'meta_id' => $post['meta_id'],
				'meta_key' => $post['meta_key'],
				'parent_id' => $post['parentId'] ?? null,
				'folder' => $post['folder_name'],
			]);

			if( isset( $post['redirect_to']) )
			{
				return redirect( $post['redirect_to'] );
			}else
			{
				Flash::set("Folder {$post['folder_name']} created.");
				return request()->return();
			}

		}
		public function show($id)
		{
			$foldersWithFiles = $this->folder->fetchWithFiles([
				'id' => $id
			]);

			if( !$foldersWithFiles ){

				echo die("Folder does not exists ");
				return false;
			}

			$foldersWithFiles = $foldersWithFiles[0];

			$data = [
				'title' => 'Folder Files',
				'folder' => $foldersWithFiles
			];

			return $this->view('folder/show' , $data);
		}

		public function delete($id)
		{
			$folderDelete = $this->folder->delete($id);

			$returnTo = request()->input('returnTo');

			Flash::set($this->folder->getMessageString() );
			if( !$folderDelete) 
				Flash::set($this->folder->getErrorString() , 'danger');

			return redirect($returnTo);
		}
	}