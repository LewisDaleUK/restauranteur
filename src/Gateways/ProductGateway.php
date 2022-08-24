<?php

namespace Lewisdaleuk\Restauranteur\Gateways;

use Lewisdaleuk\Restauranteur\Core\Gateway;
use Lewisdaleuk\Restauranteur\Models\Product;
use Lewisdaleuk\Restauranteur\Models\Menu;

class ProductGateway extends Gateway {
	public function __construct()
	{
		parent::__construct("product");
	}

	public function save(object $instance): int {
		if ($instance->id) {
			$this->database->build_and_execute(
				"UPDATE {$this->table} SET title = %s, price = %f, menu_id = %d WHERE id = %d",
					$instance->title,
					$instance->price,
					$instance->menu->id,
					$instance->id
			);
			return $instance->id;
		}

		$this->database->build_and_execute(
			"INSERT INTO {$this->table} (title, price, menu_id) VALUES ('%s', %f, %d)",
				$instance->title,
				$instance->price,
				$instance->menu->id
		);
		return $this->database->get_last_id();
	}

	public function list_by_menu(Menu $menu): array {
		$this->database->build_and_execute(
			"SELECT * FROM {$this->table} WHERE menu_id = %d", $menu->id
		);

		return array_map(fn($x) => $this->map_with_menu($menu, $x), $this->database->get_results());
	}

	public function map(?array $row): ?object {
		if ($row === null) {
			return null;
		}

		return new Product(
			id: $row['id'],
			title: $row['title'],
			price: $row['price'],
			menu: (new MenuGateway())->get($row['menu_id'])
		);
	}

	public function map_with_menu(Menu $menu, ?array $row): ?object {
		if ($row === null) {
			return null;
		}

		return new Product(
			id: $row['id'],
			title: $row['title'],
			price: $row['price'],
			menu: $menu
		);
	}
}