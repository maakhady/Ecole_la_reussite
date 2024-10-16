<?php

class EditEleveModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function updateEleve($id, $eleveData) {
        $allowedFields = ['matricule', 'nom', 'prenom', 'date_naissance', 'nom_tuteur', 'tel_tuteur','email_tuteur','departement', 'classe'];
        $updates = [];
        $params = [':id' => $id];

        foreach ($allowedFields as $field) {
            if (isset($eleveData[$field]) && $eleveData[$field] !== '') {
                $updates[] = "$field = :$field";
                $params[":$field"] = $eleveData[$field];
            }
        }

        if (empty($updates)) {
            throw new Exception("Aucune donnée valide fournie pour la mise à jour.");
        }

        $sql = "UPDATE eleves SET " . implode(', ', $updates) . " WHERE id = :id";
        error_log("Requête SQL: " . $sql);
        error_log("Paramètres: " . print_r($params, true));
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            error_log("Nombre de lignes affectées: " . $stmt->rowCount());
            header("location: eleves.php");

            if ($stmt->rowCount() === 0) {
                throw new Exception("Aucun élève trouvé avec l'ID fourni ou aucune modification n'a été effectuée.");
            }

            return true;
        } catch (PDOException $e) {
            $this->logError($e, "Erreur lors de la mise à jour de l'élève");
            throw new Exception("Une erreur est survenue lors de la mise à jour de l'élève.");
        }
    }

    public function getEleveById($id) {
        $sql = "SELECT id, matricule, nom, prenom, date_naissance, nom_tuteur, tel_tuteur, email_tuteur, departement, classe
                FROM eleves
                WHERE id = :id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                throw new Exception("Aucun élève trouvé avec l'ID fourni.");
            }

            return $result;
        } catch (PDOException $e) {
            $this->logError($e, "Erreur lors de la récupération de l'élève");
            throw new Exception("Une erreur est survenue lors de la récupération de l'élève.");
        }
    }

    private function logError(PDOException $e, $message) {
        error_log($message . ": " . $e->getMessage());
    }
}