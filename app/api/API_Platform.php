<?php

	class API_Platform extends Controller
	{
		public function saveNDA()
		{

			$this->user = model('UserModel');

			$post = request()->inputs();

			$imageAdditional = 'data:image/png;base64,';
			$imageString = $imageAdditional.= $post['image'];
			
			$res = $this->user->addNDA([
				'base64Image' => $imageString,
				'id'      => $post['id']
			]);

			ee(api_response( ['data:image/png;base64,' , $post , $res] ));
		}


	}