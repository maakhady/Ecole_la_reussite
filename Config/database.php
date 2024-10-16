<?php
// Idéalement, ces constantes devraient être dans un fichier de configuration séparé
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'ecole_la_reussite');

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }

    public static function getDatabaseTables() {
        $pdo = self::getInstance();
        try {
            $stmt = $pdo->query("SHOW TABLES");
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des tables : " . $e->getMessage());
        }
    }

    // Empêcher le clonage de l'instance
    private function __clone() {}

    // Empêcher la désérialisation de l'instance
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}