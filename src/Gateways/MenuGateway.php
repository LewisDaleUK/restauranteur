<?php

namespace Lewisdaleuk\Restauranteur\Gateways;

use Lewisdaleuk\Restauranteur\Core\Gateway;
use Lewisdaleuk\Restauranteur\Models\Menu;

class MenuGateway extends Gateway {
	public function __construct()
	{
		parent::__construct("menu");
	}

	public function save(object $instance): int {
		if ($instance->id) {
			$this->database->build_and_execute(
				"UPDATE {$this->table} SET title = %s WHERE id = %d", $instance->title, $instance->id
			);
			return $instance->id;
		}

		$this->database->build_and_execute(
			"INSERT INTO {$this->table} (title) VALUES ('%s')", $instance->title
		);
		return $this->database->get_last_id();
	}

	public function map(?array $row): ?object {
		if ($row === null) {
			return null;
		}

		$menu = new Menu(
			id: $row['id'],
			title: $row['title'],
		);
		$menu->products = (new ProductGateway())->list_by_menu($menu);

		return $menu;
	}
}