<?php

class UserModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllUsers() {
        $sql = "SELECT u.id, u.matricule, u.nom, u.prenom, r.nom_role as role, u.email, u.date_embauche
                FROM users u
                JOIN roles r ON u.role_id = r.id";

        return $this->executeQuery($sql);
    }

    public function getUserById($id) {
        $sql = "SELECT u.id, u.matricule, u.nom, u.prenom, r.nom_role as role, u.email, u.date_embauche, u.role_id
                FROM users u
                JOIN roles r ON u.role_id = r.id
                WHERE u.id = :id";

        return $this->executeQuery($sql, [':id' => $id], true);
    }

    public function createUser($userData) {
        $sql = "INSERT INTO users (matricule, nom, prenom, email, role_id, date_embauche) 
                VALUES (:matricule, :nom, :prenom, :email, :role_id, :date_embauche)";

        $params = [
            ':matricule' => $userData['matricule'],
            ':nom' => $userData['nom'],
            ':prenom' => $userData['prenom'],
            ':email' => $userData['email'],
            ':role_id' => $userData['role_id'],
            ':date_embauche' => $userData['date_embauche']
        ];

        return $this->executeQuery($sql, $params);
    }

    public function updateUser($id, $userData) {
        $sql = "UPDATE users 
                SET matricule = :matricule, nom = :nom, prenom = :prenom, 
                    email = :email, role_id = :role_id, date_embauche = :date_embauche
                WHERE id = :id";

        $params = [
            ':id' => $id,
            ':matricule' => $userData['matricule'],
            ':nom' => $userData['nom'],
            ':prenom' => $userData['prenom'],
            ':email' => $userData['email'],
            ':role_id' => $userData['role_id'],
            ':date_embauche' => $userData['date_embauche']
        ];

        return $this->executeQuery($sql, $params);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        return $this->executeQuery($sql, [':id' => $id]);
    }

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
    public function compterEnseignants() {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role_id = 4";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    public function compterProfesseurs() {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role_id = 3";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    public function compterAutresEmployes() {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role_id IN (1, 2, 5, 6, 7, 8)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
}


}