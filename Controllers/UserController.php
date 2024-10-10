<?php
require_once 'Models/UserModel.php';


class UserController {
    public $userModel;

    // Le constructeur reçoit l'objet PDO 
    public function __construct($pdo) {
        // Initialisation du modèle avec la connexion PDO
        $this->userModel = new UserModel($pdo);
    }

    // Méthode pour lister les utilisateurs
    public function listUsers() {
        try { 
            // Récupérer tous les utilisateurs depuis le modèle
            $users = $this->userModel->getAllUsers();
            // var_dump($users); // Ajoutez ceci pour voir ce qui est retourné
            $enseignants = $this->userModel->compterEnseignants();
            $prof = $this->userModel->compterProfesseurs();
            $employes=$this->userModel->compterAutresEmployes();
            // Si $users n'est pas défini ou vide, on l'initialise comme un tableau vide
            if (empty($users)) {
                $users = [];
            }
    
            // Inclure la vue pour afficher les utilisateurs
            include('Views/Eleve/userListView.php'); // Assurez-vous que la vue est incluse ici

        } catch (Exception $e) {
            // En production, il vaut mieux enregistrer l'erreur dans un fichier log
            error_log($e->getMessage(), 3, 'logs/errors.log');
            // Vous pouvez aussi afficher un message générique à l'utilisateur
            echo 'Une erreur est survenue. Veuillez réessayer plus tard.';
        }
    }
} 
?>

