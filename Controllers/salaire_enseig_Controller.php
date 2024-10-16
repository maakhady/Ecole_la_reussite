<?php
require_once 'Models/salaire_enseig_Model.php';

class SalaireEnseignantController {
    private $model;

    public function __construct($pdo) {
        $this->model = new SalaireEnseignantModel($pdo);
    }

    public function index() {
        $salaires = $this->model->getSalaires();
        
        // Débogage
        error_log("Salaires récupérés du modèle : " . print_r($salaires, true));
        
        // Vérifions si $salaires est bien un tableau
        if (!is_array($salaires)) {
            error_log("$salaires n'est pas un tableau. Type : " . gettype($salaires));
            $salaires = []; // Si ce n'est pas un tableau, initialisons-le comme un tableau vide
        }
        
        error_log("Salaires avant d'être passés à la vue : " . print_r($salaires, true));
        
        require 'Views/Comptable/salaire_enseig_View.php';
    }

    public function getSalaireByClasse($classe) {
        $salaire = $this->model->getSalaireByClasse($classe);
        $this->sendJsonResponse($salaire);
    }

    public function ajouterSalaire() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_classe = $_POST['id_classe'] ?? null;
            $salaire = $_POST['salaire'] ?? null;

            if ($id_classe && $salaire) {
                $result = $this->model->ajouterSalaire($id_classe, $salaire);
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

    public function mettreAJourSalaireEnseignant() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $salaire = $_POST['salaire_brut'] ?? null;

            if ($id && $salaire) {
                $result = $this->model->mettreAJourSalaireEnseignant($id, $salaire);
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
            $id_classe = $_POST['id_classe'] ?? null;

            if ($id_classe) {
                $result = $this->model->supprimerSalaire($id_classe);
                if ($result) {
                    $this->sendJsonResponse(['success' => true, 'message' => 'Salaire supprimé avec succès']);
                } else {
                    $this->sendJsonResponse(['success' => false, 'message' => 'Erreur lors de la suppression du salaire'], 400);
                }
            } else {
                $this->sendJsonResponse(['success' => false, 'message' => 'ID de classe manquant'], 400);
            }
        }
    }

    private function sendJsonResponse($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
    }
}