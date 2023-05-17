<?php 	

	abstract class ModelCore
	{

		protected $_coreErrors = [];

 		protected $_errors = [];

 		protected $_messages = [];

 		public function addError($error)
		{
			$this->_errors [] = $error;
		}

		public function getErrors()
		{
			return $this->_errors;
		}

		public function getError()
		{
			return end($this->_errors);
		}

		public function getErrorString()
		{
			return implode(',' , $this->_errors);
		}



		public function addMessage($message)
		{
			$this->_messages [] = $message;
		}

		public function getMessages()
		{
			return $this->_messages;
		}

		public function getMessageString()
		{
			return implode(',', $this->_messages);
		}

		public function getCoreErrors()
		{
			return $this->_coreErrors;
		}
	}