<?php declare(strict_types=1);

namespace Lewisdaleuk\Restauranteur\Core\Router;

class Router {
    private array $routes;

    private function trim_route(string $route): string {
        $route = $route == "/" ? $route : rtrim($route, "/");
        $route = str_replace("/", "\/", $route);

        return $route;
    }

    private function format_route(string $route): string {
        $formatted = $this->trim_route($route);
        return "#^$formatted$#";      
    }

    public function get(string $route, callable $fn) {
        $this->routes[] = new Route(Method::GET, $this->format_route($route), $fn);
    }

    public function post(string $route, callable $fn) {
        $this->routes[] = new Route(Method::POST, $this->format_route($route), $fn);
    }

    private function method_to_enum(string $method): Method {
        switch ($method) {
            case "GET":
                return Method::GET;
            case "POST":
                return Method::POST;
            default:
                return Method::UNKNOWN;
        }
    }

    private function get_params(array $matches): array {
        array_shift($matches);
        $results = array();

        foreach ($matches as $match) {
            $results[] = $match[0];
        }
        return $results;
    }

    public function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $this->method_to_enum($_SERVER['REQUEST_METHOD']);

        $num_matched = 0;

        $response = new Response();

        foreach($this->routes as $route) {
            if ($method == $route->type) {
                $matches = array();
                if (preg_match_all($route->pattern, $uri, $matches)) {
                    $num_matched++;
                    $fn = $route->fn;
                    $params = $this->get_params($matches);
                    $response->status_code = StatusCode::Ok;
                    $response->body .= $fn(new Request($params, $uri, $method, $_POST), $response);
                }
            }
        }

        if (!$num_matched) {
            // Handle 404
            $response->status_code = StatusCode::NotFound;
        }

        $this->respond($response);
    }

    private function map_status_code(StatusCode $code): int {
        switch ($code) {
            case StatusCode::NotFound:
                return 404;
            case StatusCode::Ok:
                return 200;
            case StatusCode::InternalError:
                return 500;
            case StatusCode::Redirect:
                return 300;
            case StatusCode::BadRequest:
                return 400;
            default:
                return 501;
        }
    }

    private function respond(Response $response) {
        http_response_code($this->map_status_code($response->status_code));

        echo $response->body;
    }
}

?>