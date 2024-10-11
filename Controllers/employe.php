<?php

session_start();
require_once "../Models/employeModel.php"; // Inclure le modèle User

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['email'], $_POST['telephone'], $_POST['role_id'])) {
        $nom = htmlspecialchars(trim($_POST['nom']));
        $prenom = htmlspecialchars(trim($_POST['prenom']));
        $date_naissance_str = $_POST['date_naissance'];
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $telephone = htmlspecialchars(trim($_POST['telephone']));
        $role_id = (int)$_POST['role_id'];
        $mot_de_passe = !empty($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : null;

        // Validation des champs
        $validationResult = User::validate($nom, $prenom, $date_naissance_str, $email, $telephone, $role_id, $mot_de_passe);

        if ($validationResult === true) {
            if (User::exists($email) || User::exisTtel($telephone)) {
                
                $_SESSION['exist_mail'] = User::exists($email);
                $_SESSION['exist_telephone'] = User::exisTtel($telephone);

                // Redirection en cas d'existence de l'email
                $_SESSION['old_data'] = $_POST;
                header('Location: ../Views/Employe/ajout_employeView.php');
                exit;
            } else {
                // Récupération des matières si le rôle est professeur
                $matieres = [];
                if ($role_id == User::ROLE_PROFESSEUR) {
                    if (isset($_POST['matiere1'])) {
                        $matiere_1 = htmlspecialchars(trim($_POST['matiere1']));
                        $matieres[] = $matiere_1; // Ajouter la première matière
                    }
                    if (isset($_POST['matiere2'])) {
                        $matiere_2 = htmlspecialchars(trim($_POST['matiere2']));
                        // Vérification que les matières ne sont pas identiques
                        if ($matiere_2 !== $matiere_1) {
                            $matieres[] = $matiere_2; // Ajouter la seconde matière si elle est différente
                        } else {
                            // Redirection en cas de matières identiques
                            $_SESSION['old_data'] = $_POST;
                            header('Location: ../Views/Employe/ajout_employeView.php?error=sameSubjects');
                            exit;
                        }
                    }
                }

                // Vérification de la date de naissance
                $date_naissance = DateTime::createFromFormat('Y-m-d', $date_naissance_str);
                if (!$date_naissance) {
                    $_SESSION['old_data'] = $_POST;
                    header('Location: ../Views/Employe/ajout_employeView.php?error=invalidDate');
                    exit;
                }

                // Validation du numéro de téléphone
                if (!preg_match('/^[0-9]{9}$/', $telephone)) {
                    $_SESSION['old_data'] = $_POST;
                    header('Location: ../Views/Employe/ajout_employeView.php?error=invalidPhone');
                    exit;
                }

                // Récupération de la classe si le rôle est enseignant
                $classe = null;
                if ($role_id == User::ROLE_ENSEIGNANT) {
                    if (isset($_POST['classe']) && !empty($_POST['classe'])) {
                        $classe = htmlspecialchars(trim($_POST['classe']));
                    } else {
                        // Redirection en cas de classe manquante
                        $_SESSION['old_data'] = $_POST;
                        header('Location: ../Views/Employe/ajout_employeView.php?error=missingClass');
                        exit;
                    }
                }

                // Création d'un nouvel utilisateur
                try {
                    $user = new User($nom, $prenom, $date_naissance, $email, $telephone, $role_id, $matieres, $classe, $mot_de_passe);
                    $user->save();

                    // Redirection après enregistrement réussi
                    unset($_SESSION['old_data']);
                    header('Location: ../index.php');
                    exit;
                } catch (Exception $e) {
                    // En cas d'erreur lors de l'enregistrement, afficher l'erreur
                    $_SESSION['old_data'] = $_POST;
                    header('Location: ../Views/Employe/ajout_employeView.php?error=' . urlencode($e->getMessage()));
                    exit;
                }
            }
        } else {
            // Redirection en cas d'erreur de validation
            $_SESSION['old_data'] = $_POST;
            header('Location: ../Views/Employe/ajout_employeView.php?error=' . urlencode($validationResult));
            exit;
        }
    } else {
        // Redirection en cas de champs manquants
        $_SESSION['old_data'] = $_POST;
        header('Location: ../Views/Employe/ajout_employeView.php?error=missingFields');
        exit;
    }
}
