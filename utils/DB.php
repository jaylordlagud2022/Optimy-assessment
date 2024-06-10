<?php

class DB
{
    private \PDO $pdo;

    private static ?self $instance = null;

    /**
     * DB constructor.
     * Establishes a connection to the database.
     *
     * @throws \PDOException
     */
    private function __construct()
    {
        // Database connection parameters
        $dsn = 'mysql:dbname=phptest;host=127.0.0.1';
        $user = 'root';
        $password = 'pass'; // Change to your new password

        try {
            // Establish the database connection
            $this->pdo = new \PDO($dsn, $user, $password);
            
            // Set PDO error mode to throw exceptions
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            // If connection fails, throw PDOException
            throw new \PDOException('Connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Singleton pattern implementation to get the single instance of the class.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Executes a SELECT query and returns the result set.
     *
     * @param string $sql The SQL query.
     * @return array The result set.
     */
    public function select(string $sql): array
    {
        $sth = $this->pdo->query($sql);
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Executes an SQL statement and returns the number of affected rows.
     *
     * @param string $sql The SQL statement to execute.
     * @param array $params Parameters for the SQL statement.
     * @return int The number of affected rows.
     */
    public function exec(string $sql, array $params = []): int
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @return string The ID of the last inserted row.
     */
    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}
?>
