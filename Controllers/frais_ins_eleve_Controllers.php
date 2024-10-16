<?php

class EspaceComptController {
    private $model;

    // Constructeur pour initialiser le modèle
    public function __construct($model) {
        $this->model = $model;
    }

    // Méthode pour afficher les informations d'un élève par son matricule
    public function afficherEleve($matricule) {
        try {
            return $this->model->getEleveBymatricule($matricule);
        } catch (Exception $e) {
            // Gérer l'erreur (redirection ou message d'erreur)
            $_SESSION['error'] = $e->getMessage();
            return null;
        }
    }

    // Méthode pour gérer la soumission du formulaire de frais
    public function enregistrerFrais($data) {
        try {
            // Appeler le modèle pour enregistrer les frais
            $this->model->enregistrerFrais($data);
            $_SESSION['message'] = "Frais d'inscription enregistrés avec succès !";
        } catch (Exception $e) {
            // Gérer l'erreur (message d'erreur)
            $_SESSION['error'] = $e->getMessage();
        }
    }
}