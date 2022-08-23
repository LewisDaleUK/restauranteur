<?php

namespace Lewisdaleuk\Restauranteur\Core;

use Exception;

class Database
{
    private string $host;
    private string $name;
    private string $user;
    private string $password;
    private string $driver;
    private \PDO $connection;
    private \PDOStatement $result;

	private static ?Database $instance = null;

    public function __construct()
    {
        $this->host = getenv('DB_HOST');
        $this->name = getenv('DB_NAME');
        $this->user = getenv('DB_USER');
        $this->password = getenv('DB_PASSWORD');
        $this->driver = getenv('DB_DRIVER') ?? 'pgsql';
        
        $this->create_connection();
    }

    private function create_connection() : void
    {
        $connectionString = "$this->driver:host=$this->host;dbname=$this->name";
        $this->connection = new \PDO($connectionString, $this->user, $this->password);
    }

    public function get_last_id(?string $name = null) : ?int {
        return intval($this->connection->lastInsertId($name));
    }

    public function execute(string $query) : void {
        $result = $this->connection->query($query);

        if ($result !== false && $result !== null) {
            $this->result = $result;
        } else {
            throw new Exception("Query failed");
        }
    }

    /**
     * Builds an escaped query with build_query and executes it
     */
    public function build_and_execute(string $query, ...$args) {
        $query = $this->build_query($query, ...$args);
        $this->execute($query);
    }

    private function escape(mixed $unescapedString) : string {
        if ($unescapedString instanceof string) {
            return $this->connection->quote($unescapedString);
        }

        return $unescapedString;
    }

    public function get_results() : array {
        if ($this->result) {
            return $this->result->fetchAll();
        } else {
            return [];
        }
    }

    public function build_query(string $query, ...$args) {
        if (count($args) === 0) {
            return $query;
        }

        return sprintf($query, ...array_map(fn($x) => $this->escape($x), $args));
    }

    public function get_first_result() {
        if ($this->result) {
            $results = $this->result->fetchAll();

            if (count($results)) {
                return $results[0];
            }
            return null;
        }

        return null;
    }

	public static function get_instance(): Database {
		if (self::$instance === null) {
			self::$instance = new Database();
		}

		return self::$instance;
	}
}