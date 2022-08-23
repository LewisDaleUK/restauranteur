<?php

namespace Lewisdaleuk\Restauranteur\Models;

class Menu {
	public function __construct(
		public int $id,
		public string $title
	)
	{}
}