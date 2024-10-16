<?php

class SalaireProfesseurModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getSalairesProfesseurs() {
        $query = "SELECT * FROM salaire_prof";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Débogage
        error_log("Requête SQL exécutée : " . $query);
        error_log("Résultat de la requête : " . print_r($result, true));

        return $result ? $result : []; // Retourne un tableau vide si aucun résultat
    }

    public function getSalaireByMatiere($matiere) {
        $query = "SELECT * FROM salaire_prof WHERE prof_matiere = :matiere";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':matiere', $matiere);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ajouterSalaireProfesseur($matiere, $taux_horaire) {
        $query = "INSERT INTO salaire_prof (prof_matiere, taux_horaire) VALUES (:matiere, :taux_horaire)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':matiere', $matiere);
        $stmt->bindParam(':taux_horaire', $taux_horaire);
        return $stmt->execute();
    }

    public function mettreAJourSalaireProfesseur($id, $taux_horaire) {
        $query = "UPDATE salaire_prof SET taux_horaire = :taux_horaire WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':taux_horaire', $taux_horaire, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function supprimerSalaireProfesseur($id) {
        $query = "DELETE FROM salaire_prof WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getSalaireById($id) {
        $query = "SELECT * FROM salaire_prof WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}