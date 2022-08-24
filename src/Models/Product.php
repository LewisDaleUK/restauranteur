<?php

namespace Lewisdaleuk\Restauranteur\Models;

class Product {
	public function __construct(
		public string $title,
		public float $price,
		public Menu $menu,
		public ?int $id = 0,
	)
	{}
}