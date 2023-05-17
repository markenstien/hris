<?php 

	
	class Test extends Controller
	{

		public function index()
		{
			// $_href = URL.DS._route('user:verification' , seal(1));
			// $_anchor = "<a href='{$_href}'>clicking this link</a>";

			// $email_content = <<<EOF
			// 	<h3> User Verification </h3>
			// 	<p> Thank you for registering on out platform , 
			// 		Verify your Registration by <br/>{$_anchor}</p>
			// EOF;

			// $email_body = wEmailComplete($email_content);

			// _mail('chromaticsoftwares@gmail.com' , "Verify Account" , $email_body);
		}

		public function template() {

			return $this->view('test/template');
		}
	}