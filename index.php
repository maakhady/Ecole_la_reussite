<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('DEBUG_MODE', true);

require_once 'Config/database.php';
require_once 'Controllers/UserController.php';
require_once 'Controllers/EleveController.php';
require_once 'Controllers/salaire_enseig_Controller.php';
require_once 'Controllers/salaire_personnel_Controller.php';
require_once 'Controllers/salaire_prof_Controller.php';
// require_once 'Controllers/employesController.php';  

try {
    if (!defined('DB_SERVER') || !defined('DB_DATABASE') || !defined('DB_USERNAME') || !defined('DB_PASSWORD')) {
        throw new Exception("Les constantes de connexion à la base de données ne sont pas définies.");
    }

    $pdo = Database::getInstance();

    $userController = new UserController($pdo);
    $eleveController = new EleveController($pdo);
    $salaireEnseignantController = new SalaireEnseignantController($pdo);
    $salairePersonnelController = new SalairePersonnelController($pdo);
    $salaireProfesseurController = new SalaireProfesseurController($pdo);
    // $employesController = new EmployesController($pdo);

    $action = $_POST['action'] ?? $_GET['action'] ?? 'listUsers';

    switch ($action) {
        case 'listUsers':
            $userController->listUsers();
            break;
        case 'inscriptionEleve':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $eleveController->ajouterEleve($_POST);
            } else {
                $eleveController->afficherFormulaireInscription();
            }
            break;
        case 'listSalairesEnseignants':
            $salaireEnseignantController->index();
            break;
        case 'getSalaireByClasse':
            $classe = $_GET['classe'] ?? null;
            if ($classe) {
                $salaireEnseignantController->getSalaireByClasse($classe);   
            } else {
                throw new Exception("Classe non spécifiée pour obtenir le salaire.");
            }
            break; 
        case 'listSalairesPersonnels':
            $salairePersonnelController->index();
            break;
        case 'getSalaireByRole':
            $role = $_GET['role'] ?? null;
            if ($role) {
                $salairePersonnelController->getSalaireByRole($role);   
            } else {
                throw new Exception("Rôle non spécifié pour obtenir le salaire.");
            }
            break;
        case 'listSalairesProfesseurs':
                $salaireProfesseurController->index();
                break;
            
        case 'getSalaireByMatiere':
                $matiere = $_GET['matiere'] ?? null;
                if ($matiere) {
                    $salaireProfesseurController->getSalaireByMatiere($matiere);
                } else {
                    throw new Exception("Matière non spécifiée pour obtenir le salaire.");
                }
                break;
        case 'mettreAJourSalaireEnseignant':
                $salaireEnseignantController->mettreAJourSalaireEnseignant();
            break;
        case 'mettreAJourSalairePersonnel':
                $salairePersonnelController->mettreAJourSalairePersonnel();
            break;
        case 'mettreAJourSalaireProfesseur':
                $salaireProfesseurController->mettreAJourSalaireProfesseur();
            break;   
        case 'listEmployes':
                $employesController->listEmployes();
             break;
        case 'ajouterEmploye':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $employesController->ajouterEmploye($_POST);
                } else {
                    $employesController->afficherFormulaireInscription();
                }
                break;
            case 'voirDetailsEmploye':
                $id = $_GET['id'] ?? null;
                if ($id) {
                    $employesController->voirDetailsEmploye($id);
                } else {
                    throw new Exception("ID de l'employé non spécifié.");
                }
                break;
            case 'modifierEmploye':
                $id = $_GET['id'] ?? null;
                if ($id) {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $employesController->updateEmploye($id, $_POST);
                    } else {
                        $employesController->showUpdateEmployeForm($id);
                    }
                } else {
                    throw new Exception("ID de l'employé non spécifié pour la modification.");
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