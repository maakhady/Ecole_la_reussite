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
            if (!$user) {
                throw new Exception("Utilisateur non trouvé.");
            }
            return $user;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
        }
    }

    public function updateUser($id, $userData) {
        try {
            $result = $this->model->updateUser($id, $userData);
            if ($result) {
                error_log("Mise à jour réussie pour l'utilisateur ID: $id");
                return true;
            } else {
                error_log("Échec de la mise à jour pour l'utilisateur ID: $id");
                return false;
            }
        } catch (Exception $e) {
            error_log("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
            throw $e;
        }
    }

    public function getAllRoles() {
        try {
            $roles = $this->model->getAllRoles();
            if (empty($roles)) {
                throw new Exception("Aucun rôle trouvé.");
            }
            return $roles;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des rôles : " . $e->getMessage());
        }
    }
}
?>