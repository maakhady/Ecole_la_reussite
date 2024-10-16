<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class PaiementModel {
    private $db;
    private $itemsPerPage = 10;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getPersonnelAPayer($page = 1, $mois = '', $recherche = '') {
        try {
            $offset = ($page - 1) * $this->itemsPerPage;

            $query = "SELECT u.id, u.nom, u.prenom, r.nom_role, s.salaire_brut, 
                             p.statut_paiement, p.mode_paiement, p.mois, p.montant
                      FROM users u
                      JOIN roles r ON u.role_id = r.id
                      LEFT JOIN salaire_personnel s ON s.role = r.nom_role
                      LEFT JOIN paiement_personnels p ON u.id = p.user_id
                      WHERE r.nom_role NOT IN ('Professeur', 'Enseignant')";

            $params = [];

            if ($mois !== '') {
                $query .= " AND (p.mois = :mois OR p.mois IS NULL)";
                $params[':mois'] = $mois;
            }

            if ($recherche !== '') {
                $query .= " AND (u.nom LIKE :recherche OR u.prenom LIKE :recherche)";
                $params[':recherche'] = '%' . $recherche . '%';
            }

            $query .= " ORDER BY u.nom, u.prenom LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($query);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }

            $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur de requête : " . $e->getMessage());
        }
    }

    public function getTotalPages($mois = '', $recherche = '') {
        try {
            $query = "SELECT COUNT(*) as total
                      FROM users u
                      JOIN roles r ON u.role_id = r.id
                      LEFT JOIN paiement_personnels p ON u.id = p.user_id
                      WHERE r.nom_role NOT IN ('Professeur', 'Enseignant')
                      AND (p.mois = :mois OR :mois = '')
                      AND (u.nom LIKE :recherche OR u.prenom LIKE :recherche OR :recherche = '')";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':mois', $mois ?: date('Y-m'), PDO::PARAM_STR);
            $stmt->bindValue(':recherche', '%' . $recherche . '%', PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return ceil($result['total'] / $this->itemsPerPage);
        } catch (PDOException $e) {
            throw new Exception("Erreur de comptage : " . $e->getMessage());
        }
    }

    public function getEmployeDetails($id) {
        try {
            $query = "SELECT u.id, u.nom, u.prenom, r.nom_role, s.salaire_brut
                      FROM users u
                      JOIN roles r ON u.role_id = r.id
                      LEFT JOIN salaire_personnel s ON r.nom_role = s.role
                      WHERE u.id = :id";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des détails : " . $e->getMessage());
        }
    }

    public function enregistrerPaiement($userId, $mois, $modePaiement, $montant) {
        try {
            $query = "INSERT INTO paiement_personnels (user_id, salaire_personnel_id, mois, mode_paiement, montant, statut_paiement, date_paiement)
                      VALUES (:user_id, (SELECT id FROM salaire_personnel WHERE role = (SELECT nom_role FROM roles WHERE id = (SELECT role_id FROM users WHERE id = :user_id))), :mois, :mode_paiement, :montant, 'payé', NOW())
                      ON DUPLICATE KEY UPDATE
                      mode_paiement = :mode_paiement, montant = :montant, statut_paiement = 'payé', date_paiement = NOW()";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':mois', $mois, PDO::PARAM_STR);
            $stmt->bindValue(':mode_paiement', $modePaiement, PDO::PARAM_STR);
            $stmt->bindValue(':montant', $montant, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'enregistrement du paiement : " . $e->getMessage());
        }
    }
}
?>
