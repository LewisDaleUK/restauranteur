<?php declare(strict_types=1);

namespace Lewisdaleuk\Restauranteur\Core\Router;

class Route {
    public function __construct(
        public readonly Method $type,
        public readonly string $pattern,
        public readonly mixed $fn
    )
    {}
}

?>
