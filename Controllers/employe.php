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
            $mot_de_passe = $_POST['mot_de_passe']; // Le hachage sera effectué dans le modèle
        }

        // Validation des champs
        $validationResult = User::validate($nom, $prenom, $date_naissance, $email, $telephone, $role_id, $mot_de_passe);

        if ($validationResult === true) {
            if (User::exists($email)) {
                // Redirection en cas d'existence de l'email
                header('Location: ../Views/Employe/ajout_employeView.php?error=exists');
                exit;
            } else {
                // Récupération des matières si le rôle est professeur
                $matieres = [];
                if ($role_id == User::ROLE_PROFESSEUR) {
                    if (isset($_POST['matiere1'], $_POST['matiere2'])) {
                        $matiere_1 = htmlspecialchars(trim($_POST['matiere1']));
                        $matiere_2 = htmlspecialchars(trim($_POST['matiere2']));

                        // Vérification que les matières ne sont pas identiques
                        if ($matiere_1 !== $matiere_2) {
                            $matieres[] = $matiere_1; // Ajouter la première matière
                            $matieres[] = $matiere_2; // Ajouter la seconde matière
                        } else {
                            // Redirection en cas de matières identiques
                            header('Location: ../Views/Employe/ajout_employeView.php?error=sameSubjects');
                            exit;
                        }
                    } else {
                        // Redirection en cas de matières manquantes
                        header('Location: ../Views/Employe/ajout_employeView.php?error=missingSubjects');
                        exit;
                    }
                }

                // Récupération de la classe si le rôle est enseignant
                $classe = null;
                if ($role_id == User::ROLE_ENSEIGNANT) {
                    if (isset($_POST['classe'])) {
                        $classe = htmlspecialchars(trim($_POST['classe']));
                    } else {
                        // Redirection en cas de classe manquante
                        header('Location: ../Views/Employe/ajout_employeView.php?error=missingClass');
                        exit;
                    }
                }

                // Création d'un nouvel utilisateur
                try {
                    $user = new User($nom, $prenom, $date_naissance, $email, $telephone, $role_id, $matieres, $classe, $mot_de_passe);
                    $user->save();

                    // Redirection après enregistrement réussi
                    header('Location: ../../Views/Eleve/userListView.php');
                    exit;
                } catch (Exception $e) {
                    // En cas d'erreur lors de l'enregistrement, afficher l'erreur
                    header('Location: ../Views/Employe/ajout_employeView.php?error=' . urlencode($e->getMessage()));
                    exit;
                }
            }
        } else {
            // Redirection en cas d'erreur de validation
            header('Location: ../Views/Employe/ajout_employeView.php?error=' . urlencode($validationResult));
            exit;
        }
    } else {
        // Redirection en cas de champs manquants
        header('Location: ../Views/Employe/ajout_employeView.php?error=missingFields');
        exit;
    }
}
?>