<?php
require_once 'Config/database.php';
require_once 'Controllers/EleveController.php';

try {
    
    if (!defined('DB_SERVER') || !defined('DB_DATABASE') || !defined('DB_USERNAME') || !defined('DB_PASSWORD')) {
        throw new Exception("Les constantes de connexion à la base de données ne sont pas définies.");
    }

    // Connexion à la base de données
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialisation du contrôleur_
    $controller = new EleveController($pdo);

    // Déterminer l'action à effectuer
    $action = $_POST['action'] ?? 'listEleves';

    switch ($action) {
        case 'listEleves':
            $controller->listEleves(); // Affiche la liste des élèves
            break;

        // case 'createEleve':
        //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //         $eleveData = [
        //             'matricule' => $_POST['matricule'] ?? null,
        //             'nom' => $_POST['nom'] ?? null,
        //             'prenom' => $_POST['prenom'] ?? null,
        //             'date_naissance' => $_POST['date_naissance'] ?? null,
        //             'nom_tuteur' => $_POST['nom_tuteur'] ?? null,
        //             'tel_tuteur' => $_POST['tel_tuteur'] ?? null,
        //             'email_tuteur' => $_POST['email_tuteur'] ?? null,
        //             'departement' => $_POST['departement'] ?? null,
        //             'classe' => $_POST['classe'] ?? null,
        //             'date_inscription' => $_POST['date_inscription'] ?? null,
        //         ];
        //         $controller->createEleve($eleveData); // Créer un nouvel élève
        //     } else {
        //         $controller->showCreateEleveForm(); // Affiche le formulaire de création
        //     }
        //     break;

        case 'editEleve':
            $id = $_POST['id'] ?? null;
            if ($id) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $eleveData = [
                        'matricule' => $_POST['matricule'] ?? null,
                        'nom' => $_POST['nom'] ?? null,
                        'prenom' => $_POST['prenom'] ?? null,
                        'date_naissance' => $_POST['date_naissance'] ?? null,
                        'nom_tuteur' => $_POST['nom_tuteur'] ?? null,
                        'tel_tuteur' => $_POST['tel_tuteur'] ?? null,
                        'email_tuteur' => $_POST['email_tuteur'] ?? null,
                        'departement' => $_POST['departement'] ?? null,
                        'classe' => $_POST['classe'] ?? null,
                        'date_inscription' => $_POST['date_inscription'] ?? null,
                    ];
                    $controller->updateEleve($id, $eleveData); // Met à jour l'élève
                } else {
                    $controller->showUpdateEleveForm($id); // Affiche le formulaire de mise à jour
                }
            } else {
                header('Location: eleves.php?action=listEleves'); // Redirige si l'ID n'est pas fourni
                exit;
            }
            break;

        // case 'deleteEleve':
        //     $id = $_POST['id'] ?? null;
        //     if ($id) {
        //         $controller->deleteEleve($id); // Supprime l'élève
        //     } else {
        //         header('Location: eleves.php?action=listEleves'); // Redirige si l'ID n'est pas fourni
        //         exit;
        //     }
        //     break;

        default:
            header('Location: eleves.php?action=listEleves'); // Action non reconnue, redirige vers la liste des élèves
            exit;
    }

} catch (PDOException $e) {
    // Gérer les erreurs de connexion à la base de données
    error_log("ERREUR : Impossible de se connecter à la base de données. " . $e->getMessage());
    die("Une erreur est survenue. Veuillez réessayer plus tard.");
} catch (Exception $e) {
    // Gérer les autres exceptions
    error_log("ERREUR : " . $e->getMessage());
    die("Une erreur est survenue. Veuillez réessayer plus tard.");
}
?>
