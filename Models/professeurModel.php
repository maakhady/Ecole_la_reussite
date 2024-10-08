<?php

class ProfesseurModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer tous les professeurs
    public function getAllProfesseurs() {
        $stmt = $this->pdo->prepare("SELECT u.id, u.nom, u.prenom, u.email, GROUP_CONCAT(m.nom_matieres SEPARATOR ', ') AS matieres
                                      FROM users u
                                      JOIN professeur_matiere pm ON u.id = pm.professeur_id
                                      JOIN matieres m ON pm.matiere_id = m.id
                                      WHERE u.role_id = 3
                                      GROUP BY u.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un professeur par ID
    public function getProfesseurById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id AND role_id = 3");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un nouveau professeur
    public function createProfesseur($professeurData) {
        $stmt = $this->pdo->prepare("INSERT INTO users (nom, prenom, email, role_id) VALUES (:nom, :prenom, :email, 3)");
        $stmt->execute([
            'nom' => $professeurData['nom'],
            'prenom' => $professeurData['prenom'],
            'email' => $professeurData['email'],
        ]);
        $professeurId = $this->pdo->lastInsertId();

        // Associer les matières
        foreach ($professeurData['matieres'] as $matiereId) {
            $this->associateMatiere($professeurId, $matiereId);
        }
    }

    // Mettre à jour un professeur
    public function updateProfesseur($id, $professeurData) {
        $stmt = $this->pdo->prepare("UPDATE users SET nom = :nom, prenom = :prenom, email = :email WHERE id = :id");
        $stmt->execute([
            'nom' => $professeurData['nom'],
            'prenom' => $professeurData['prenom'],
            'email' => $professeurData['email'],
            'id' => $id,
        ]);

        // Mettre à jour les matières
        $this->updateMatieres($id, $professeurData['matieres']);
    }

    // Supprimer un professeur
    public function deleteProfesseur($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id AND role_id = 3");
        $stmt->execute(['id' => $id]);
    }

    // Associer une matière à un professeur
    private function associateMatiere($professeurId, $matiereId) {
        $stmt = $this->pdo->prepare("INSERT INTO professeur_matiere (professeur_id, matiere_id) VALUES (:professeur_id, :matiere_id)");
        $stmt->execute([
            'professeur_id' => $professeurId,
            'matiere_id' => $matiereId,
        ]);
    }

    // Mettre à jour les matières d'un professeur
    private function updateMatieres($professeurId, $matieres) {
        // Supprimer les matières existantes
        $this->pdo->prepare("DELETE FROM professeur_matiere WHERE professeur_id = :professeur_id")
            ->execute(['professeur_id' => $professeurId]);

        // Réassocier les matières
        foreach ($matieres as $matiereId) {
            $this->associateMatiere($professeurId, $matiereId);
        }
    }
}
?>
