<?php
require_once 'Models/salaire_prof_Model.php';

class SalaireProfesseurController {
    private $model;

    public function __construct($pdo) {
        $this->model = new SalaireProfesseurModel($pdo);
    }

    public function index() {
        error_log("Méthode index() de SalaireProfesseurController appelée");
        $professeurs = $this->model->getSalairesProfesseurs();
        
        // Débogage
        error_log("Données des professeurs récupérées du modèle : " . print_r($professeurs, true));
        
        // Vérifions si $professeurs est bien un tableau
        if (!is_array($professeurs)) {
            error_log("$professeurs n'est pas un tableau. Type : " . gettype($professeurs));
            $professeurs = []; // Si ce n'est pas un tableau, initialisons-le comme un tableau vide
        }
        
        require 'Views/Comptable/salaire_prof_View.php';
    }

    public function getSalaireByMatiere() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $matiere = $_GET['matiere'] ?? null;
            if ($matiere) {
                $taux_horaire = $this->model->getSalaireByMatiere($matiere);
                $this->sendJsonResponse($taux_horaire);
            } else {
                $this->sendJsonResponse(['error' => 'Matière non spécifiée'], 400);
            }
        }
    }

    public function ajouterSalaire() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $matiere = $_POST['matiere'] ?? null;
            $taux_horaire = $_POST['taux_horaire'] ?? null;

            error_log("Tentative d'ajout de salaire - Matière: $matiere, Taux horaire: $taux_horaire");

            if ($matiere && $taux_horaire) {
                $result = $this->model->ajouterSalaireProfesseur($matiere, $taux_horaire);
                if ($result) {
                    $this->sendJsonResponse(['success' => true, 'message' => 'Taux horaire ajouté avec succès']);
                } else {
                    $this->sendJsonResponse(['success' => false, 'message' => 'Erreur lors de l\'ajout du taux horaire'], 400);
                }
            } else {
                $this->sendJsonResponse(['success' => false, 'message' => 'Données manquantes'], 400);
            }
        }
    }

    public function mettreAJourSalaireProfesseur() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $taux_horaire = $_POST['taux_horaire'] ?? null;

            error_log("Tentative de mise à jour de salaire - ID: $id, Nouveau taux horaire: $taux_horaire");

            if ($id && $taux_horaire) {
                $result = $this->model->mettreAJourSalaireProfesseur($id, $taux_horaire);
                if ($result) {
                    $this->sendJsonResponse(['success' => true, 'message' => 'Taux horaire mis à jour avec succès']);
                } else {
                    $this->sendJsonResponse(['success' => false, 'message' => 'Erreur lors de la mise à jour du taux horaire'], 400);
                }
            } else {
                $this->sendJsonResponse(['success' => false, 'message' => 'Données manquantes'], 400);
            }
        }
    }

    public function supprimerSalaire() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            error_log("Tentative de suppression de salaire - ID: $id");

            if ($id) {
                $result = $this->model->supprimerSalaireProfesseur($id);
                if ($result) {
                    $this->sendJsonResponse(['success' => true, 'message' => 'Taux horaire supprimé avec succès']);
                } else {
                    $this->sendJsonResponse(['success' => false, 'message' => 'Erreur lors de la suppression du taux horaire'], 400);
                }
            } else {
                $this->sendJsonResponse(['success' => false, 'message' => 'ID manquant'], 400);
            }
        }
    }

    private function sendJsonResponse($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
    }
}