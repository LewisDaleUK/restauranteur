<?php

namespace Lewisdaleuk\Restauranteur\Core;

abstract class Gateway {
	protected Database $database;

	public function __construct(
		protected string $table
	)
	{
		$this->database = new Database();
	}	

	public function get(int $id): ?object {
		$this->database->build_and_execute("SELECT * FROM {$this->table} WHERE id = %d", $id);
		return $this->map($this->database->get_first_result());
	}

	public function delete(int $id) {
		$this->database->build_and_execute("DELETE FROM {$this->table} WHERE id = %d", $id);
	}

	public function list(int $page = 1, int $per_page = 10): array {
		$this->database->build_and_execute(
			"SELECT * FROM {$this->table} LIMIT %d OFFSET %d", $per_page, ($page - 1) * $per_page
		);
		return array_map([$this, 'map'], $this->database->get_results());
	}

	public abstract function save(object $instance): int;

	/**
	 * Map a database row into an instance of the object the Gateway controls
	 * 
	 * @param ?object - the database row
	 * @return ?object - an instance of the Model that the gateway represnets
	 */
	public abstract function map(?object $row) : ?object;
}