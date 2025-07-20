<?php
class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $port;
    private $pdo;
    
    public function __construct() {
        // Use PostgreSQL environment variables
        $this->host = $_ENV['PGHOST'] ?? 'localhost';
        $this->dbname = $_ENV['PGDATABASE'] ?? 'luxury_fashion';
        $this->username = $_ENV['PGUSER'] ?? 'postgres';
        $this->password = $_ENV['PGPASSWORD'] ?? '';
        $this->port = $_ENV['PGPORT'] ?? 5432;
        
        $this->connect();
    }
    
    private function connect() {
        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->pdo;
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception('Database query failed: ' . $e->getMessage());
        }
    }
    
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
?>
