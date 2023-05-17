<?php
    class UploaderHelper
    {   
        protected $extensions;
        protected $errors = [];

        public function __construct()
        {
          $this->name = '';
          $this->extensions = ['jpeg' , 'jpg' , 'png' , 'bitmap','csv' , 'xls' ,'xlsx' , 'csv' ,'pdf','docx'];
        }


        public function setName($name = '')
        {
          $this->name = $name;
          return $this;
        }

        public function setPath($path)
        {
            $this->path = $path;
            return $this;
        }

        public function setFile($fileName)
        {
            try{

                if(empty($_FILES[$fileName])){
                    throw new \Exception("No File Found");
                }

                $this->file = $file  = $_FILES[$fileName];
                $this->tempName = $file['tmp_name'];
                $this->nameOld  = $file['name'];

                $ext = explode('.' , $this->nameOld);
                $this->ext = strtolower(end($ext));

            }catch(\Exception $e)
            {
                $this->setErrors($e->getMessage());
                return false;
            }
        }


        public function upload()
        {
            $isExtensionValid = $this->validateExtension();

            /** CHECK IF DATA IS SET */
            if($this->file['error'] != '0')
            {
                $this->setErrors("Unable to Read file");
                return false;
            }
            if($isExtensionValid)
            {
                $path = $this->path;

                /*Add File Extension To the name*/
                 if(!empty($this->name)){
                   $newName = str_replace(' ', '_', $this->name);
                   $this->name = $newName.'.'.$this->ext;
                 }
                 
                 /**
                  * Make New name
                  */
                 if(empty($this->name)){
                   $this->name = $this->makeNewName();
                 }
                /**
                 * Check if file exists if not exist make one
                 */
                if(! file_exists($path)){
                    mkdir($path);
                }

                $isUploaded = $this->moveUpload();

                /** If upload is successful */
                if($isUploaded === true)
                    return true;

                $this->setErrors($isUploaded);
                return false;
            }else{
                $msg = " Invalid Extension '{$this->ext}' allowed extensions(".implode(',' , $this->extensions).")";
                $this->setErrors($msg);
                return false;
            }
        }

        public function getName()
        {
            return $this->name ?? 'N/A';
        }

        public function getNameOld()
        {
            return $this->nameOld;
        }

        public function getErrors()
        {
            return $this->errors;
        }

        public function getExtension()
        {
            return $this->ext;
        }

        public function getPath()
        {
            return $this->path;
        }

        /**
         * CORE PROCEESESS
         * SET ERORS , VALIDATIONS MAKE NEW NAME MOVE UPLOAD
         */
        protected function setErrors($error) : void
        {
            array_push($this->errors , $error);
        }

        protected function validateExtension()
        {
            if(in_array($this->ext , $this->extensions))
                return true;
            return false;
        }

        protected function makeNewName()
        {
            $prefix = date('m');
            $body   = get_token_random_char(15);
            return strtoupper("{$prefix}_{$body}.{$this->ext}");
        }

        protected function moveUpload()
        {
            $tmpName = $this->tempName;
            $path    = $this->path;
            $newName = $this->name;

            $fullPath = $path.DS.$newName;
            try{
                move_uploaded_file($tmpName,$fullPath);
                return true;
            }catch(\Exception $e) {
                return $e->getMessage();
            }
        }
    }
