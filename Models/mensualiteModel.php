<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class paiement_mensuel {
    private $conn;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($db) {
        $this->conn = $db;
    }


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
    // Méthode pour enregistrer un paiement mensuel via le matricule
    public function paiementmensuelParMatricule($matricule, $mois, $montant, $mode_paiement, $date_inscription, $date_modif) {
        // Préparer la requête d'insertion avec récupération de l'élève par matricule
        $query = "INSERT INTO fraisinscription (id, classe, mois, montant, mode_paiement, date_inscription, date_modif) 
                  SELECT id, classe, :mois, :montant, :mode_paiement, :date_inscription, :date_modif 
                  FROM eleves 
                  WHERE matricule = :matricule";

        // Préparer la requête
        $stmt = $this->conn->prepare($query);

        // Lier les paramètres
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':mois', $mois);
        $stmt->bindParam(':montant', $montant);
        $stmt->bindParam(':mode_paiement', $mode_paiement);
        $stmt->bindParam(':date_inscription', $date_inscription);
        $stmt->bindParam(':date_modif', $date_modif);

        // Exécuter la requête et vérifier les erreurs
        if ($stmt->execute()) {
            return true;  // Succès
        } else {
            // En cas d'échec, afficher l'erreur
            printf("Erreur : %s.\n", $stmt->error);
            return false;  // Échec
        }
    }

 }
?>
