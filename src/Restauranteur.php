<?php


define("__PROJECT_ROOT__", dirname(__DIR__, 1));

require_once(__PROJECT_ROOT__ . "/vendor/autoload.php" );

use Lewisdaleuk\Readerlist\Router\Response;
use Lewisdaleuk\Restauranteur\Core\Router\Router;
use Lewisdaleuk\Restauranteur\Core\View;
use Lewisdaleuk\Restauranteur\Gateways\MenuGateway;

$router = new Router();

$router->get('/', function($req, $response) {
	return $response->render("index.phtml", ["menus" => (new MenuGateway())->list()]);
});

$router->get('/menu/add', function($req, $response) {
	return $response->render("menu/add.phtml");
});

$router->dispatch();