<?php

class SalairePersonnelModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getSalairesPersonnel() {
        $query = "SELECT * FROM salaire_personnel";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Débogage
        error_log("Requête SQL exécutée : " . $query);
        error_log("Résultat de la requête : " . print_r($result, true));

        return $result ? $result : []; // Retourne un tableau vide si aucun résultat
    }

    public function getSalaireByRole($role) {
        $query = "SELECT * FROM salaire_personnel WHERE role = :role";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ajouterSalairePersonnel($role, $salaire_brut) {
        $query = "INSERT INTO salaire_personnel (role, salaire_brut) VALUES (:role, :salaire_brut)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':salaire_brut', $salaire_brut);
        return $stmt->execute();
    }

    public function mettreAJourSalairePersonnel($id, $salaire_brut) {
        $query = "UPDATE salaire_personnel SET salaire_brut = :salaire_brut WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':salaire_brut', $salaire_brut);
        return $stmt->execute();
    }

    public function supprimerSalairePersonnel($id) {
        $query = "DELETE FROM salaire_personnel WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}