<?php


define("__PROJECT_ROOT__", dirname(__DIR__, 1));

require_once(__PROJECT_ROOT__ . "/vendor/autoload.php" );

use Lewisdaleuk\Restauranteur\Core\View;

$router = new \Bramus\Router\Router;

$router->get('/', function() {
	$view = new View("index.phtml");
	echo $view->render();
});

$router->run();