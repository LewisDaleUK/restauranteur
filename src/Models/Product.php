<?php

namespace Lewisdaleuk\Restauranteur\Models;

class Product {
	public function __construct(
		public int $id,
		public string $title,
		public float $price,
		public Menu $menu
	)
	{}
}