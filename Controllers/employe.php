<?php
require_once "../Models/employeModel.php"; // Inclure le modèle User

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['email'], $_POST['telephone'], $_POST['role_id'])) {
        $nom = htmlspecialchars(trim($_POST['nom']));
        $prenom = htmlspecialchars(trim($_POST['prenom']));
        $date_naissance = $_POST['date_naissance'];
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $telephone = htmlspecialchars(trim($_POST['telephone']));
        $role_id = (int)$_POST['role_id'];
        $mot_de_passe = null;

        if (!empty($_POST['mot_de_passe'])) {
            $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
        }

        $validationResult = User::validate($nom, $prenom, $date_naissance, $email, $telephone, $role_id, $mot_de_passe);

        if ($validationResult === true) {
            if (User::exists($email)) {
                // Afficher un message d'erreur : "Utilisateur déjà existant"
                header('Location: ../Views/Employe/ajout_employeView.php?error=exists');
                exit;
            } else {
                $user = new User($nom, $prenom, $date_naissance, $email, $telephone, $role_id, $mot_de_passe);
                $user->save();
                // Rediriger vers une page de confirmation ou de connexion
                header('Location: ../index.php');
                exit;
            }
        } else {
            // Afficher les messages d'erreur sur la page d'inscription
            header('Location: ../Views/Employe/ajout_employeView.php?error=' . $validationResult);
            exit;
        }
    } else {
        header('Location: ../Views/Employe/ajout_employeView.php?error=missingFields');
        exit;
    }
}

?>