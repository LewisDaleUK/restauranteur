<?php declare(strict_types=1);

namespace Lewisdaleuk\Restauranteur\Core\Router;

enum StatusCode {
    case NotFound;
    case Ok;
    case Redirect;
    case InternalError;
    case BadRequest;
}

?>