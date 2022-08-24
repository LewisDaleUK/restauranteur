<?php


define("__PROJECT_ROOT__", dirname(__DIR__, 1));

require_once(__PROJECT_ROOT__ . "/vendor/autoload.php" );

use Lewisdaleuk\Readerlist\Router\Response;
use Lewisdaleuk\Restauranteur\Core\Router\Router;
use Lewisdaleuk\Restauranteur\Core\View;
use Lewisdaleuk\Restauranteur\Gateways\MenuGateway;
use Lewisdaleuk\Restauranteur\Gateways\ProductGateway;
use Lewisdaleuk\Restauranteur\Models\Menu;
use Lewisdaleuk\Restauranteur\Models\Product;

$router = new Router();

$router->get('/', function($req, $response) {
	return $response->render("index.phtml", ["menus" => (new MenuGateway())->list()]);
});

$router->get('/menu/add', function($req, $response) {
	return $response->render("menu/add.phtml");
});

$router->post('/menu/add', function($req, $response) {
	$model = new Menu(title: $req->post['title']);
	(new MenuGateway())->save($model);

	return $response->redirect("/");
});

$router->get('/menu/(\d+)/product/add', function($req, $response) {
	return $response->render("product/add.phtml", ["menu_id" => $req->params[0]]);
});

$router->post('/menu/(\d+)/product/add', function($req, $response) {
	$model = new Product(
		title: $req->post['title'],
		price: $req->post['price'],
		menu: (new MenuGateway())->get($req->params[0])
	);
	(new ProductGateway())->save($model);

	return $response->redirect("/");
});
$router->dispatch();