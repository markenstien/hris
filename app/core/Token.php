<?php 
	namespace Core;

	class Token 
	{

		public function createMix( $prefix = null )
		{
			return strtoupper($prefix.random_number(3).'-'.random_letter(5));
		}

		public function createNumbers($prefix = null)
		{
			return strtoupper($prefix.random_number(8));
		}

		public function createLetters($prefix = null)
		{
			return strtoupper($prefix.random_letter(8));
		}
	}