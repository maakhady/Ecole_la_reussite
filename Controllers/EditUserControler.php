<?php
require_once 'Models/EditUserModel.php';
class EditUserController {
    private $model;

    public function __construct(EditUserModel $model) {
        $this->model = $model;
    }

    public function editUser($id) {
        try {
            $user = $this->model->getUserById($id);
            
            return $user;
        } catch (Exception $e) {
            // Gérer l'erreur (par exemple, rediriger vers une page d'erreur)
            return "Erreur : " . $e->getMessage();
        }
    }

    public function updateUser($id, $userData) {
        try {
            $result = $this->model->updateUser($id, $userData);
            if ($result) {
                // Rediriger vers une page de succès ou la liste des utilisateurs
                return "L'utilisateur a été mis à jour avec succès.";
                
            }
        } catch (Exception $e) {
            // Gérer l'erreur (par exemple, réafficher le formulaire avec un message d'erreur)
            return "Erreur : " . $e->getMessage();
        }
    }
}