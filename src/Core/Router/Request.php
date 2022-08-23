<?php declare(strict_types=1);

namespace Lewisdaleuk\Restauranteur\Core\Router;

class Request {
    public function __construct(
        public array $params,
        public readonly string $uri,
        public readonly Method $method,
        public readonly array $post = [],
    ) {}
}

?>