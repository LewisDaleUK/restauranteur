<?php

namespace Lewisdaleuk\Restauranteur\Models;

class Menu {
	public function __construct(
		public string $title,
		public ?int $id = 0,
		public array $products = []
	)
	{}
}