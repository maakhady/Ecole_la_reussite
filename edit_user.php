<?php
require_once __DIR__ . '/Config/database.php';
require_once __DIR__ . '/Models/EditUserModel.php';
require_once __DIR__ . '/Controllers/EditUserControler.php';

function getPDO() {
    $dsn = 'mysql:host=localhost;dbname=ecole_la_reussite;charset=utf8mb4';
    $username = 'root';
    $password = '';
    
    try {
        return new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}

$pdo = getPDO();
$editUserModel = new EditUserModel($pdo);
$editUserController = new EditUserController($editUserModel);

function redirectWithMessage($url, $message, $type = 'success') {
    $encodedMessage = urlencode($message);
    header("Location: $url?message=$encodedMessage&type=$type");
    exit;
}

function handleEditUser($id, $editUserController) {
    try {
        $user = $editUserController->editUser($id);
        $roles = $editUserController->getAllRoles();
        require 'Views/Eleve/edit_user_view.php';
    } catch (Exception $e) {
        $error = "Erreur : " . $e->getMessage();
        require 'Views/Eleve/edit_user_view.php';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    if (!$id) {
        redirectWithMessage('index.php', "ID de l'utilisateur non spécifié", 'error');
    }

    $userData = [
        'matricule' => $_POST['matricule'] ?? null,
        'nom' => $_POST['nom'] ?? null,
        'prenom' => $_POST['prenom'] ?? null,
        'email' => $_POST['email'] ?? null,
        'role_id' => $_POST['role_id'] ?? null,
        'date_embauche' => $_POST['date_embauche'] ?? null,
    ];

    try {
        $result = $editUserController->updateUser($id, $userData);
        if ($result === true) {
            redirectWithMessage('Views/Eleve/userListView.php', 'Utilisateur mis à jour avec succès');
        } else {
            throw new Exception($result);
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        handleEditUser($id, $editUserController);
    }
} else {
    $id = $_GET['id'] ?? null;
    if ($id === null) {
        redirectWithMessage('index.php', "ID de l'utilisateur non spécifié", 'error');
    }

    handleEditUser($id, $editUserController);
}
?>