<?php
class EditUserModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function updateUser($id, $userData) {
        $allowedFields = ['matricule', 'nom', 'prenom', 'role_id', 'email', 'date_embauche'];
        $updates = [];
        $params = [':id' => $id];

        foreach ($allowedFields as $field) {
            if (isset($userData[$field]) && $userData[$field] !== '') {
                $updates[] = "$field = :$field";
                $params[":$field"] = $userData[$field];
            }
        }

        if (empty($updates)) {
            throw new Exception("Aucune donnée valide fournie pour la mise à jour.");
        }

        $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = :id";
        error_log("Requête SQL : $sql");
        error_log("Paramètres : " . print_r($params, true));
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            header("location: index.php");
            if ($stmt->rowCount() === 0) {
                throw new Exception("Aucun utilisateur trouvé avec l'ID fourni ou aucune modification n'a été effectuée.");
            }

            return true;
        } catch (PDOException $e) {
            $this->logError($e, "Erreur lors de la mise à jour de l'utilisateur");
            throw new Exception("Une erreur est survenue lors de la mise à jour de l'utilisateur.");
        }
    }

    public function getUserById($id) {
        $sql = "SELECT u.id, u.matricule, u.nom, u.prenom, u.role_id, r.nom_role as role, u.email, u.date_embauche
                FROM users u
                JOIN roles r ON u.role_id = r.id
                WHERE u.id = :id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                throw new Exception("Aucun utilisateur trouvé avec l'ID fourni.");
            }

            return $result;
        } catch (PDOException $e) {
            $this->logError($e, "Erreur lors de la récupération de l'utilisateur");
            throw new Exception("Une erreur est survenue lors de la récupération de l'utilisateur.");
        }
    }

    public function getAllRoles() {
        $sql = "SELECT id, nom_role FROM roles";
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError($e, "Erreur lors de la récupération des rôles");
            throw new Exception("Une erreur est survenue lors de la récupération des rôles.");
        }
    }

    private function logError(PDOException $e, $message) {
        error_log($message . ": " . $e->getMessage());
    }
}
?>