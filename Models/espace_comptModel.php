<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ComptModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db; // Assignation de la connexion
    }

    // Méthode pour récupérer tous les élèves
    public function getAllEleves() {
        try {
            $stmt = $this->conn->prepare("SELECT nom, prenom, matricule, classe FROM eleves");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère tous les élèves sous forme de tableau associatif
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des élèves : " . $e->getMessage();
            return [];
        }
    }
}
?>