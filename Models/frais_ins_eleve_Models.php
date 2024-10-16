<?php

class EspaceComptModel {
    private $db;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($db) {
        $this->db = $db;
    }

    // Méthode pour récupérer les informations d'un élève par son matricule
    public function getEleveBymatricule($matricule) {
        try {
            $query = "SELECT nom, prenom, matricule, classe FROM eleves WHERE matricule = :matricule"; // Changez :id en :id
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':matricule', $matricule, PDO::PARAM_STR); // Corrigez ici
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des informations de l'élève : " . $e->getMessage());
        }
    }

    // Méthode pour enregistrer les frais d'inscription d'un élève
    public function enregistrerFrais($data) {
        try {
            $query = "INSERT INTO fraisinscription (matricule, montant, mode_paiement) 
                      VALUES (:matricule, :montant, :mode_paiement)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':matricule', $data['matricule'], PDO::PARAM_STR);
            $stmt->bindParam(':montant', $data['montant'], PDO::PARAM_INT);
            $stmt->bindParam(':mode_paiement', $data['mode_paiement'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'enregistrement des frais : " . $e->getMessage());
        }
    }
}