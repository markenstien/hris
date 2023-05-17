<?php 	

	class AttachmentMetaHelper
	{

		public $name,
		$metaId,
		$metaKey,
		$metaSrc,
		$metaPath,
		$metaFullPath;

		private $model;

		public function __construct()
		{
			$this->model = model('AttachmentMetaModel');
		}

		public function setSrc($src)
		{
			$this->metaSrc = $src;
			return $this;
		}


		public function setFullPath($path)
		{
			$this->metaFullPath = $path;
			return $this;
		}

		public function setPath($path)
		{
			$this->metaPath = $path;
			return $this;
		}

		public function setName($name)
		{
			$this->name = $name;
			return $this;
		}

		public function setId($metaId)
		{
			$this->metaId = $metaId;
			return $this;
		}

		public function setKey($metaKey)
		{
			$this->metaKey = $metaKey;
			return $this;
		}


		public function upload()
		{
			$res = $this->model->store([
				'meta_id' => $this->metaId,
				'meta_key' => $this->metaKey,
				'name'  => $this->name,
				'meta_src' => $this->metaSrc,
				'meta_path' => $this->metaPath,
				'meta_fullpath' => $this->metaFullPath,
			]);

			if( $res ){
				return true;
			}else{
				return false;
			}
		}
	}