<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BandSite\BaseViewModel;
use BandSite\RegisterViewModel;
use BandSite\LoginViewModel;
use BandSite\LogoutViewModel;
use BandSite\StoreViewModel;
use BandSite\ResetViewModel;
use BandSite\GetImageViewModel;


session_start();

// setup whoops error handling framework
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// determine what page we're on
$file = $_SERVER['PHP_SELF'];

preg_match('/\/([-a-z]+)\.php$/', $file, $matches);

if (count($matches) !== 2) {
	http_response_code(404);
	echo "Not Found";
	exit();
}

$route = $matches[1];

// instantiate the right model for the page
switch($route) {
	case 'index':
		$model = new BaseViewModel();
	break;

	case 'register':
		$model = new RegisterViewModel();
	break;

	case 'login':
		$model = new LoginViewModel();
	break;
	
	case 'logout':
		$model = new LogoutViewModel();
	break;

	case 'store':
		$model = new StoreViewModel();
	break;

	case 'reset':
		$model = new ResetViewModel();
	break;

	case 'get-image':
		$model = new GetImageViewModel();
	break;

	default:
		$model = new BaseViewModel();
	break;
}
