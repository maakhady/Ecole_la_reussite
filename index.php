<?php
session_start();

// if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'directeur') {
//     header('Location: login.php');
//     exit();
// }
define('DEBUG_MODE', true);
require_once 'Config/database.php';
require_once 'Controllers/UserController.php';
require_once 'Controllers/EleveController.php';




try {
    if (!defined('DB_SERVER') || !defined('DB_DATABASE') || !defined('DB_USERNAME') || !defined('DB_PASSWORD')) {
        throw new Exception("Les constantes de connexion à la base de données ne sont pas définies.");
    }

    $pdo = Database::getInstance();

    $userController = new UserController($pdo);
    $eleveController = new EleveController($pdo);

    $action = $_POST['action'] ?? $_GET['action'] ?? 'listUsers';

    switch ($action) {
        case 'listUsers':
            $userController->listUsers();
            break;
        // case 'updateUser':
        //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //         $id = $_POST['id'] ?? null;
        //         $userData = [
        //             'matricule' => $_POST['matricule'] ?? null,
        //             'nom' => $_POST['nom'] ?? null,
        //             'prenom' => $_POST['prenom'] ?? null,
        //             'email' => $_POST['email'] ?? null,
        //             'role_id' => $_POST['role_id'] ?? null,
        //             'date_embauche' => $_POST['date_embauche'] ?? null,
        //         ];
        //         $userController->updateUser($id, $userData);
        //     } else {
        //         header('Location: index.php?action=listUsers');
        //         exit;
        //     }
        //     break;
        // case 'editUser':
        //     $id = $_GET['id'] ?? null;
        //     if ($id) {
        //         $userController->editUser($id);
        //     } else {
        //         header('Location: index.php?action=listUsers');
        //         exit;
        //     }
        //     break;
        case 'inscriptionEleve':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $eleveController->ajouterEleve($_POST);
            } else {
                $eleveController->afficherFormulaireInscription();
            }
            break;
        default:
            header('Location: index.php?action=listUsers');
            exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "ERREUR : Impossible de se connecter à la base de données. " . $e->getMessage();
    header('Location: index.php?action=listUsers');
    exit;
} catch (Exception $e) {
    $_SESSION['error'] = "ERREUR : " . $e->getMessage();
    header('Location: index.php?action=listUsers');
    exit;
}