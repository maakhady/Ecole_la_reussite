<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ComptModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db; // Assignation de la connexion
    }






    // Méthode pour récupérer tous les élèves avec leur montant de frais
    public function getAllEleves() {
        try {
            // Jointure entre `eleves` et `fraisinscription` pour récupérer les montants
            $stmt = $this->conn->prepare("
                SELECT eleves.id, eleves.nom, eleves.prenom, eleves.matricule, eleves.classe, fraisinscription.montant, fraisinscription.mois  
                FROM eleves
                LEFT JOIN fraisinscription ON eleves.id = fraisinscription.id
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des élèves : " . $e->getMessage();
            return [];
        }
    }




    // Méthode pour récupérer un élève par son matricule
    public function getEleveByid($id) {
        try {
            $stmt = $this->conn->prepare("SELECT id,nom, prenom, matricule, classe FROM eleves WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Récupère un seul élève sous forme associative
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'élève : " . $e->getMessage();
            return null;
        }
    }

    // Méthode pour enregistrer les frais d'inscription d'un élève
    public function enregistrerFrais($data) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO fraisinscription ( id, classe, montant, mode_paiement) 
                                          VALUES (:id, :classe, :montant, :mode_paiement)");

            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':classe', $data['classe']);
            $stmt->bindParam(':montant', $data['montant']);
            $stmt->bindParam(':mode_paiement', $data['mode_paiement']);
            $stmt->execute();

        // Retourner le dernier frais_id inséré
        return $this->conn->lastInsertId(); // Récupère l'ID du dernier frais inséré
        } catch (PDOException $e) {
            echo "Erreur lors de l'enregistrement des frais : " . $e->getMessage();
        }
    }

            // ComptModel.php

            public function verifierPaiement($id) {
                try {
                    $stmt = $this->conn->prepare("SELECT COUNT(*) FROM fraisinscription WHERE id = :id");
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $count = $stmt->fetchColumn();

                    return $count > 0; // Retourne true si l'élève a un paiement enregistré, false sinon
                } catch (PDOException $e) {
                    echo "Erreur lors de la vérification du paiement : " . $e->getMessage();
                    return false;
                }
            }


            public function supprimerFrais($id) {
                try {
                    $stmt = $this->conn->prepare("DELETE FROM fraisinscription WHERE id = :id");
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo "Erreur lors de la suppression des frais : " . $e->getMessage();
                }
            }



}
?>