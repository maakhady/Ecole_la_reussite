<?php
require_once 'Models/salaire_personnel_Model.php';

class SalairePersonnelController {
    private $model;

    public function __construct($pdo) {
        $this->model = new SalairePersonnelModel($pdo);
    }

    public function index() {
        $salaires = $this->model->getSalairesPersonnel();
        
        // Débogage
        error_log("Salaires du personnel récupérés du modèle : " . print_r($salaires, true));
        
        // Vérifions si $salaires est bien un tableau
        if (!is_array($salaires)) {
            error_log("$salaires n'est pas un tableau. Type : " . gettype($salaires));
            $salaires = []; // Si ce n'est pas un tableau, initialisons-le comme un tableau vide
        }
        
        error_log("Salaires du personnel avant d'être passés à la vue : " . print_r($salaires, true));
        
        require 'Views/Comptable/salaire_personnel_View.php';
    }

    public function getSalaireByRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $role = $_GET['role'] ?? null;
            if ($role) {
                $salaire = $this->model->getSalaireByRole($role);
                $this->sendJsonResponse($salaire);
            } else {
                $this->sendJsonResponse(['error' => 'Role non spécifié'], 400);
            }
        }
    }

    public function ajouterSalaire() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'] ?? null;
            $salaire_brut = $_POST['salaire_brut'] ?? null;

            if ($role && $salaire_brut) {
                $result = $this->model->ajouterSalairePersonnel($role, $salaire_brut);
                if ($result) {
                    $this->sendJsonResponse(['success' => true, 'message' => 'Salaire ajouté avec succès']);
                } else {
                    $this->sendJsonResponse(['success' => false, 'message' => 'Erreur lors de l\'ajout du salaire'], 400);
                }
            } else {
                $this->sendJsonResponse(['success' => false, 'message' => 'Données manquantes'], 400);
            }
        }
    }

    public function mettreAJourSalairePersonnel() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $salaire_brut = $_POST['salaire_brut'] ?? null;

            if ($id && $salaire_brut) {
                $result = $this->model->mettreAJourSalairePersonnel($id, $salaire_brut);
                if ($result) {
                    $this->sendJsonResponse(['success' => true, 'message' => 'Salaire mis à jour avec succès']);
                } else {
                    $this->sendJsonResponse(['success' => false, 'message' => 'Erreur lors de la mise à jour du salaire'], 400);
                }
            } else {
                $this->sendJsonResponse(['success' => false, 'message' => 'Données manquantes'], 400);
            }
        }
    }

    public function supprimerSalaire() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $result = $this->model->supprimerSalairePersonnel($id);
                if ($result) {
                    $this->sendJsonResponse(['success' => true, 'message' => 'Salaire supprimé avec succès']);
                } else {
                    $this->sendJsonResponse(['success' => false, 'message' => 'Erreur lors de la suppression du salaire'], 400);
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