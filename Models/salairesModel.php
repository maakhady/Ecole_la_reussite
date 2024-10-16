<?php

class SalairesModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllSalaires($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT s.salaire_id, s.montant, s.date_revision
                FROM salaire s                
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSalaireById($id) {
        $sql = "SELECT s.salaire_id, s.montant, s.date_revision
                FROM salaire s
                WHERE u.id = :id";

        return $this->executeQuery($sql, [':id' => $id], true);
    }

    public function createSalaire($salaireData) {
        $sql = "INSERT INTO salaire (montant, date_revision) 
                VALUES (:montant, :date_revision)";

        $params = [
            ':montant' => $salaireData['montant'],
            ':date_revision' => $salaireData['date_revision'],
            
        ];

        return $this->executeQuery($sql, $params);
    }

    public function updateSalaire($id, $salaireData) {
        $sql = "UPDATE employes 
                SET montant = :montant
                WHERE id = :id";

        $params = [
            ':id' => $id,
            ':montant' => $salaireData['montant']
        ];

        return $this->executeQuery($sql, $params);
    }

    /*public function deleteEmploye($id) {
        $sql = "DELETE FROM employes WHERE employe_id = :employe_id";
        return $this->executeQuery($sql, [':employe_id' => $id]);
    }*/

    private function executeQuery($sql, $params = [], $singleResult = false) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            if ($singleResult) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result ?: null;
            } else {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $results ?: [];
            }
        } catch (PDOException $e) {
            $this->logError($e, "Erreur lors de l'exécution de la requête");
            throw new Exception("Une erreur est survenue lors de l'opération sur la base de données.");
        }
    }

    private function logError(PDOException $e, $message) {
        error_log($message . ": " . $e->getMessage());
    }
}