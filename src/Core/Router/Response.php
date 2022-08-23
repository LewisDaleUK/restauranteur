<?php declare(strict_types=1);

namespace Lewisdaleuk\Restauranteur\Core\Router;

use Lewisdaleuk\Restauranteur\Core\View;

class Response {
    public StatusCode $status_code = StatusCode::Ok;
    public string $body = "";

    public function __construct()
    {
    }

    public function json(mixed $obj): string {
        return json_encode($obj);
    }

    /**
     * Redirect the user to a new page.
     * 
     * Unlike other response methods, this is evaulated immediately, and takes precedence over other routes.
     * 
     * @param url - the URL to redirect to
     */
    public function redirect(string $url) {
        header("Location: $url", true, 301);
        die();
    }

    /**
     * Render a template, with an array of values to provide to the template
     */
    public function render(string $template, array $values = []) {
        $view = new View($template);

        return $view->render($values);
    }
}