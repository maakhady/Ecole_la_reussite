<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../Models/espace_comptModel.php';
require_once __DIR__ . '/../Config/db.php';

class ElevesController {
    private $model;

    public function __construct() {
        $database = new Database();
        $db = $database->dbConnexion();
        $this->model = new ComptModel($db);
    }

    // Méthode pour afficher la liste des élèves
    public function afficherEleves() {
        return $this->model->getAllEleves();
    }

    // Méthode pour afficher un élève spécifique par son matricule
    public function afficherEleve($id) {
        return $this->model->getEleveByid($id);
    }

    // Méthode pour enregistrer les frais d'inscription

    public function enregistrerFrais($data) {
        // Supposons que $data contient : eleve_id, classe, montant, mode_paiement
        if (isset($data['id'], $data['classe'], $data['montant'], $data['mode_paiement'])) {
            // Vérifier si l'élève a déjà payé
             // Enregistrer les frais et récupérer le frais_id
             $frais_id = $this->model->enregistrerFrais($data);
    
             if ($frais_id !== null) {
            
            // Redirection après enregistrement ou mise à jour
            header("Location: recu.php?id=" . $data['id'] . "&montant=" . $data['montant'] . "&mode_paiement=" . $data['mode_paiement']  . "&frais_id=" . $frais_id);
            exit;
        } else {
            echo "Données manquantes pour l'enregistrement des frais.";
        }
    }
    
    }

    
        // ElevesController.php

        public function obtenirStatutPaiement($id) {
            return $this->model->verifierPaiement($id) ? 'Payé' : 'À payer';
        }

        public function supprimerFrais($id) {
            // Appeler la méthode du modèle pour supprimer les frais
            $this->model->supprimerFrais($id);

            // Rediriger après la suppression
            header("Location: espace_comptView.php"); // Vous pouvez rediriger vers la page souhaitée
            exit;
        }

    
}
?>
