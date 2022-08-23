<?php


define("__PROJECT_ROOT__", dirname(__DIR__, 1));

require_once(__PROJECT_ROOT__ . "/vendor/autoload.php" );

use Lewisdaleuk\Restauranteur\Core\View;
use Lewisdaleuk\Restauranteur\Gateways\MenuGateway;

$router = new \Bramus\Router\Router;

$router->get('/', function() {
	$gateway = new MenuGateway();
	$view = new View("index.phtml");
	echo $view->render(["menus" => $gateway->list(per_page: 100)]);
});

$router->run();