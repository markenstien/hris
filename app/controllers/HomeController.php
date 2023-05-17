<?php
	
	load(['DoctorForm'], APPROOT.DS.'form');

	use Form\DoctorForm;

	class HomeController extends Controller
	{

		public function index()
		{	
			return view('home/index');
		}
	}