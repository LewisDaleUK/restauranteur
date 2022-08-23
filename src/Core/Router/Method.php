<?php declare(strict_types=1);

namespace Lewisdaleuk\Restauranteur\Core\Router;

enum Method {
    case GET;
    case POST;

    // Fallback method
    case UNKNOWN;
};