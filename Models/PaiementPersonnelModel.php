<?php 

class PaiementPersonnelModel {
    private $pdo;
    private $modesValides = ['Wave', 'Especes'];

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPaiements($page = 1, $itemsPerPage = 10) {
        $offset = ($page - 1) * $itemsPerPage;
        
        $sql = "SELECT u.id, u.nom, u.prenom, u.matricule, r.nom_role, s.salaire_brut, 
                       p.statut_paiement, p.mode_paiement, p.mois, p.montant
                FROM users u
                JOIN roles r ON u.role_id = r.id
                LEFT JOIN salaire_personnel s ON s.role = r.nom_role
                LEFT JOIN (
                    SELECT user_id, statut_paiement, mode_paiement, mois, montant
                    FROM paiement_personnels
                    WHERE (user_id, mois) IN (
                        SELECT user_id, MAX(mois)
                        FROM paiement_personnels
                        GROUP BY user_id
                    )
                ) p ON u.id = p.user_id
                WHERE r.nom_role NOT IN ('Professeur', 'Enseignant', 'Directeur')
                LIMIT :limit OFFSET :offset";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getPaiements: " . $e->getMessage());
            throw new Exception("Erreur lors de la récupération des paiements.");
        }
    }

    public function getTotalPaiements() {
        $sql = "SELECT COUNT(*) 
                FROM users u
                JOIN roles r ON u.role_id = r.id
                WHERE r.nom_role NOT IN ('Professeur', 'Enseignant', 'Directeur')";
        try {
            return $this->pdo->query($sql)->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur dans getTotalPaiements: " . $e->getMessage());
            throw new Exception("Erreur lors du comptage des paiements.");
        }
    }

    public function effectuerPaiement($data) {
        error_log("Début de effectuerPaiement");
        error_log("Données reçues : " . print_r($data, true));
        
        $errors = $this->validerDonnees($data);
        if (!empty($errors)) {
            error_log("Erreurs de validation : " . implode(", ", $errors));
            throw new Exception(implode(", ", $errors));
        }

        $this->pdo->beginTransaction();
        try {
            $existingPayment = $this->getPaiementExistant($data['user_id'], $data['mois']);

            if ($existingPayment) {
                $this->mettreAJourPaiement($existingPayment['id'], $data);
            } else {
                $this->ajouterNouveauPaiement($data);
            }

            error_log("Transaction terminée avec succès");
            $this->pdo->commit();
            return ['success' => true];
        } catch (PDOException $e) {
            error_log("Erreur lors de la transaction : " . $e->getMessage());
            $this->pdo->rollBack();
            throw new Exception("Une erreur est survenue lors du traitement du paiement.");
        }
    }

    public function getPaiementById($id) {
        $sql = "SELECT * FROM paiement_personnels WHERE id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getPaiementById: " . $e->getMessage());
            throw new Exception("Erreur lors de la récupération du paiement.");
        }
    }

    public function getSalaireBrut($role) {
        try {
            $stmt = $this->pdo->prepare("SELECT salaire_brut FROM salaire_personnel WHERE role = :role");
            $stmt->execute([':role' => $role]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result === false) {
                error_log("Aucun salaire trouvé pour le rôle : " . $role);
                return null;
            }
            
            return $result['salaire_brut'];
        } catch (PDOException $e) {
            error_log("Erreur dans getSalaireBrut: " . $e->getMessage());
            throw new Exception("Erreur lors de la récupération du salaire brut.");
        }
    }

    private function validerDonnees($data) {
        $errors = [];

        if (empty($data['user_id'])) {
            $errors[] = "L'ID de l'utilisateur est requis.";
        }
        if (empty($data['mois'])) {
            $errors[] = "Le mois est requis.";
        }
        if (empty($data['mode_paiement'])) {
            $errors[] = "Le mode de paiement est requis.";
        } elseif (!in_array($data['mode_paiement'], $this->modesValides)) {
            $errors[] = "Le mode de paiement est invalide. Valeur reçue : '" . $data['mode_paiement'] . "'";
        }
        if (empty($data['montant']) || !is_numeric($data['montant'])) {
            $errors[] = "Le montant est requis et doit être un nombre.";
        }
        if (empty($data['statut_paiement'])) {
            $errors[] = "Le statut de paiement est requis.";
        }

        return $errors;
    }

    private function getPaiementExistant($userId, $mois) {
        $stmt = $this->pdo->prepare("SELECT id FROM paiement_personnels WHERE user_id = :user_id AND mois = :mois");
        $stmt->execute([':user_id' => $userId, ':mois' => $mois]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function mettreAJourPaiement($id, $data) {
        $sql = "UPDATE paiement_personnels SET 
                mode_paiement = :mode_paiement,
                statut_paiement = :statut_paiement,
                montant = :montant,
                date_paiement = CURRENT_TIMESTAMP(),
                date_modif = CURRENT_TIMESTAMP()
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':mode_paiement' => $data['mode_paiement'],
            ':statut_paiement' => $data['statut_paiement'],
            ':montant' => $data['montant'],
            ':id' => $id
        ]);
    }

    private function ajouterNouveauPaiement($data) {
        $sql = "INSERT INTO paiement_personnels (user_id, mois, mode_paiement, statut_paiement, montant, date_paiement, date_creation) 
                VALUES (:user_id, :mois, :mode_paiement, :statut_paiement, :montant, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':mois' => $data['mois'],
            ':mode_paiement' => $data['mode_paiement'],
            ':statut_paiement' => $data['statut_paiement'],
            ':montant' => $data['montant']
        ]);
    }
    public function supprimerPaiement($id) {
        try {
            // Vérifier si le paiement existe
            $paiement = $this->getPaiementById($id);
            if (!$paiement) {
                throw new Exception("Le paiement avec l'ID $id n'existe pas.");
            }

            // Supprimer le paiement
            $sql = "DELETE FROM paiement_personnels WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() === 0) {
                throw new Exception("Aucun paiement n'a été supprimé. Vérifiez l'ID du paiement.");
            }

            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression du paiement: " . $e->getMessage());
            throw new Exception("Une erreur est survenue lors de la suppression du paiement.");
        }
    }
}