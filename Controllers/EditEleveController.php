<?php
require_once 'Models/EditEleveModel.php';

class EditEleveController {
    private $model;

    public function __construct(EditEleveModel $model) {
        $this->model = $model;
    }

    public function editEleve($id) {
        try {
            $eleve = $this->model->getEleveById($id);
            return $eleve;
        } catch (Exception $e) {
            // Gérer l'erreur (par exemple, rediriger vers une page d'erreur)
            return "Erreur : " . $e->getMessage();
        }
    }

    public function updateEleve($id, $eleveData) {
        try {
            $result = $this->model->updateEleve($id, $eleveData);
            if ($result) {
                // Rediriger vers une page de succès ou la liste des élèves
                return "L'élève a été mis à jour avec succès.";
            }
        } catch (Exception $e) {
            // Gérer l'erreur (par exemple, réafficher le formulaire avec un message d'erreur)
            return "Erreur : " . $e->getMessage();
        }
    }
}