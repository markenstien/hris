<?php
	ob_clean();

	$root = dirname(dirname(__FILE__));
	//config
	require_once($root.'/app/config/setup.php');
	//environment
	require_once($root.'/app/config/setup_loader.php');

	require_once($root.'/app/config/path.php');

	require_once($root.'/app/config/constants.php');

	require_once(FNCTNS.'/uncommon.php');
	//autoloader
	require_once($root.'/app/autoload.php');

	$bootstrap = new Bootstrap();
?>
