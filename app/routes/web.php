<?php
	
	$routes = [];

	$controller = '/UserController';

	$routes['user'] = [
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'create' => $controller.'/create',
		'delete' => $controller.'/destroy',
		'show'   => $controller.'/show',
		'profile' => $controller.'/profile',
		'sendAuth' => $controller.'/sendAuth',
		'register' => $controller.'/register',
		'verification' => $controller.'/verification',
		'referrral'  => $controller .'/referrral',
		'dashboard' => '/DashboardController/index'
	];

	$controller = '/AuthController';

	$routes['auth'] = [
		'login' => $controller.'/login',
		'register' => $controller.'/register',
		'logout' => $controller.'/logout',
	];
	
	$controller = '/PaymentController';

	$routes['payment'] = [
		'index' => $controller.'/index',
		'create' => $controller.'/create',
		'edit' => $controller.'/edit',
		'add' => $controller.'/add',
		'delete' => $controller.'/destroy',
		'show'   => $controller.'/show'
	];
	
	$controller = '/CategoryController';

	$routes['category'] = [
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'create' => $controller.'/create',
		'delete' => $controller.'/destroy',
		'show'   => $controller.'/show'
	];
	
	$controller = '/AttachmentController';

	$routes['attachment'] = [
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'create' => $controller.'/create',
		'delete' => $controller.'/destroy',
		'download' => $controller.'/download',
		'show'   => $controller.'/show'
	];

	$controller = '/FilesController';

	$routes['file'] = [
		'upload' => $controller.'/upload',
		'uploadWithFolderCreate' => $controller.'/uploadWithFolderCreate',
		'delete' => $controller.'/delete'
	];

	$controller = '/FolderController';

	$routes['folder'] = [
		'show' => $controller.'/show',
		'create' => $controller.'/create',
		'index' => $controller.'/index',
		'delete' => $controller.'/delete'
	];

	$controller = '/ScheduleSettingController';

	$routes['schedule'] = [
		'index' => $controller.'/index',
		'update' => $controller.'/update'
	];

	$controller = '/GovernmentIDController';
	$routes['govid'] = [
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'create' => $controller.'/addStock',
		'delete' => $controller.'/destroy',
		'show'   => $controller.'/show',
		'verification' => $controller .'/verification',
		'log'   => $controller.'/log',
	];

	$controller = '/EmploymentAttributeController';
	$routes['emp-attr'] = [
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'create' => $controller.'/create',
		'delete' => $controller.'/destroy',
		'show'   => $controller.'/show',
		'log'   => $controller.'/log',
		'position' => $controller.'/index?type=POSITION',
		'department' => $controller.'/index?type=DEPARTMENT',
	];

	$controller = '/ScheduleController';
	$routes['schedule'] = [
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'create' => $controller.'/create',
		'delete' => $controller.'/destroy',
		'show'   => $controller.'/show'
	];


	_routeInstance('tk', 'TimekeepingController', $routes, [
		'weblog' => 'webClockLogAction',
		'formlog' => 'webFormAction',
		'approve' => 'approve',
		'log' => 'log'
	]);
	
	_routeInstance('leave', 'LeaveController', $routes, [
		'approve' => 'approve'
	]);

	_routeInstance('requirement', 'RequirementController', $routes, [
		'attachFile' => 'attachFile',
		'respondentView' => 'respondentView',
		'approveRespond' => 'approveRespond',
		'deleteResponse' => 'deleteResponse'
	]);
	
	_routeInstance('viewer', 'ViewerController', $routes);
	_routeInstance('leave-point', 'LeavePointController', $routes);
	
	return $routes;
?>