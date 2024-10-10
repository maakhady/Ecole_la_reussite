<?php

class EleveModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllEleves() {
        $sql = "SELECT id, matricule, nom, prenom, date_naissance, nom_tuteur, tel_tuteur, email_tuteur, departement, classe, date_inscription, archivage
                FROM eleves
                WHERE archivage = 0
                ORDER BY date_inscription DESC";
        return $this->executeQuery($sql);
    }

    public function getEleveById($id) {
        $sql = "SELECT id, matricule, nom, prenom, date_naissance, nom_tuteur, tel_tuteur, email_tuteur, departement, classe, date_inscription, archivage
                FROM eleves
                WHERE id = :id";
        return $this->executeQuery($sql, [':id' => $id], true);
    }

    public function createEleve($eleveData) {
        $eleveData['matricule'] = $this->generateMatricule();
        $eleveData['date_inscription'] = date('Y-m-d H:i:s');

        $sql = "INSERT INTO eleves (matricule, nom, prenom, date_naissance, nom_tuteur, tel_tuteur, email_tuteur, departement, classe, date_inscription)
                VALUES (:matricule, :nom, :prenom, :date_naissance, :nom_tuteur, :tel_tuteur, :email_tuteur, :departement, :classe, :date_inscription)";

        return $this->executeQuery($sql, $eleveData);
    }

    public function updateEleve($id, $eleveData) {
        if (empty($eleveData)) {
            return 0; // Aucune modification à apporter
        }

        $setClauses = [];
        $params = [':id' => $id];

        foreach ($eleveData as $key => $value) {
            $setClauses[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        $sql = "UPDATE eleves SET " . implode(', ', $setClauses) . " WHERE id = :id";

        return $this->executeQuery($sql, $params);
    }

    // public function deleteEleve($id) {
    //     $sql = "UPDATE eleves SET archivage = 1 WHERE id = :id";
    //     return $this->executeQuery($sql, [':id' => $id]);
    // }

    private function generateMatricule() {
        $prefix = 'ELV';
        $year = date('Y');
        $randomPart = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return $prefix . $year . $randomPart;
    }

    private function executeQuery($sql, $params = [], $singleResult = false) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            if (stripos($sql, 'INSERT') === 0) {
                return $this->pdo->lastInsertId();
            } elseif (stripos($sql, 'UPDATE') === 0 || stripos($sql, 'DELETE') === 0) {
                return $stmt->rowCount();
            } elseif ($singleResult) {
                return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
            } else {
                return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
            }
        } catch (PDOException $e) {
            $this->logError($e, "Erreur lors de l'exécution de la requête : $sql");
            throw new Exception("Une erreur est survenue lors de l'opération sur la base de données.");
        }
    }

    private function logError(PDOException $e, $message) {
        error_log($message . ": " . $e->getMessage() . "\n" . $e->getTraceAsString());
    }

    public function compterTousLesEleves() {
        $sql = "SELECT COUNT(*) as total FROM eleves";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
}
    public function compterElevesPrimaire() {
        $sql = "SELECT COUNT(*) as total FROM eleves WHERE departement = :departement";
        $stmt = $this->pdo->prepare($sql);
        $departement = 'Primaire';
        $stmt->bindParam(':departement', $departement, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function compterElevesSecondaire() {
        $sql = "SELECT COUNT(*) as total FROM eleves WHERE departement = :departement";
        $stmt = $this->pdo->prepare($sql);
        $departement = 'Secondaire';
        $stmt->bindParam(':departement', $departement, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}