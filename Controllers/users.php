<?php
class UserController {
    private $employe;

    public function __construct($employe) {
        $this->employe = $employe;
    }

    public function connexion() {
        global $emailError, $passwordError; // Utiliser les variables globales pour stocker les messages d'erreur

        // Vérifier si le formulaire de connexion a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les valeurs du formulaire
            $email = $_POST['email'] ?? '';
            $motDePasse = $_POST['mot_passe'] ?? '';

            // Validation des champs
            if (empty($email)) {
                $emailError = "Veuillez entrer votre email.";
            }
            if (empty($motDePasse)) {
                $passwordError = "Veuillez entrer votre mot de passe.";
            }

            // Si les champs ne sont pas vides, procéder à l'authentification
            if (!empty($email) && !empty($motDePasse)) {
                $result = $this->employe->login($email, $motDePasse);

                if ($result === true) {
                    // Authentification réussie
                    session_start();
                    $_SESSION['user'] = $email; // ou les informations utilisateur
                    header('Location: ../index.php');
                    exit();
                } elseif ($result === 'email_incorrect') {
                    $emailError = "Adresse email incorrect.";
                } else {
                    $passwordError = "Mot de passe incorrect.";
                }
            }
        }
    }
}
?>