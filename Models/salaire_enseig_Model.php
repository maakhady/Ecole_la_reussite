<?php

class SalaireEnseignantModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getSalaires() {
        $query = "SELECT * FROM salaire_enseig ORDER BY id_classe";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Débogage
        error_log("Requête SQL exécutée : " . $query);
        error_log("Résultat de la requête : " . print_r($result, true));

        return $result ? $result : []; // Retourne un tableau vide si aucun résultat
    }

    public function getSalaireByClasse($classe) {
        $query = "SELECT * FROM salaire_enseig WHERE id_classe = :classe";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':classe', $classe);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ajouterSalaire($id_classe, $salaire) {
        $query = "INSERT INTO salaire_enseig (id_classe, salaire) VALUES (:id_classe, :salaire)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_classe', $id_classe);
        $stmt->bindParam(':salaire', $salaire);
        return $stmt->execute();
    }

    public function mettreAJourSalaireEnseignant($id, $salaire) {
        $query = "UPDATE salaire_enseig SET salaire_brut = :salaire_brut WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':salaire_brut', $salaire, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function supprimerSalaire($id_classe) {
        $query = "DELETE FROM salaire_enseig WHERE id_classe = :id_classe";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_classe', $id_classe);
        return $stmt->execute();
    }

    public function getSalaireById($id) {
        $query = "SELECT * FROM salaire_enseig WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function salaireExiste($id_classe) {
        $query = "SELECT COUNT(*) FROM salaire_enseig WHERE id_classe = :id_classe";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_classe', $id_classe);
        $stmt->execute();
        return (bool) $stmt->fetchColumn();
    }
}