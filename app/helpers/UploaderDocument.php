<?php

class UploaderDocument extends UploaderHelper
{
    protected $extensions = [
        'csv' , 'xls' ,'xlsx' , 'csv' ,'pdf' ,'docx'
    ];

    public function setDocument($name)
    {   
        $this->setFile($name);
        return $this;
    }

    /**Override function*/
    public function upload()
    {
        return parent::upload();
    }
}