<?php
require_once '../Models/LoginModel.php';
require_once '../Config/database.php';

class LoginController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db); // Modèle utilisateur
    }

    public function login() {
        // Initialisation des variables
        $email = $password = "";
        $email_err = $password_err = "";

        // Vérification si la méthode est POST (formulaire soumis)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validation de l'email
            if (empty(trim($_POST["email"]))) {
                $email_err = "Veuillez entrer votre adresse email.";
            } else {
                $email = trim($_POST["email"]);
            }

            // Validation du mot de passe
            if (empty(trim($_POST["password"]))) {
                $password_err = "Veuillez entrer votre mot de passe.";
            } else {
                $password = trim($_POST["password"]);
            }

            // Si aucune erreur dans l'email et le mot de passe
            if (empty($email_err) && empty($password_err)) {
                if ($this->userModel->login($email, $password)) {
                    header("Location: dashboard.php"); // Redirection vers le tableau de bord
                    exit();
                } else {
                    $password_err = "Email ou mot de passe incorrect.";
                }
            }

            // Charger la vue de connexion avec les erreurs
            require '../Views/LoginView.php';
        } else {
            // Si la requête est GET (pas de formulaire soumis), charger simplement la vue
            require '../Views/LoginView.php';
        }
    }
}
?>
