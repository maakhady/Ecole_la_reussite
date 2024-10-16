<?php
require_once __DIR__ .'/Config/database.php';
require_once __DIR__ . '/Models/EditUserModel.php';
require_once __DIR__ . '/Controllers/EditUserControler.php';


function getPDO() {
    $dsn = 'mysql:host=localhost;dbname=ecole_la_reussite;charset=utf8mb4';
    $username = 'root';
    $password = '';
    
    try {
        return new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}

$pdo = getPDO();
$editUserModel = new EditUserModel($pdo);
$editUserController = new EditUserController($editUserModel);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $userData = [
        'matricule' => $_POST['matricule'] ?? null,
        'nom' => $_POST['nom'] ?? null,
        'prenom' => $_POST['prenom'] ?? null,
        'email' => $_POST['email'] ?? null,
        'role_id' => $_POST['role_id'] ?? null,
        'date_embauche' => $_POST['date_embauche'] ?? null,
    ];
    
    $result = $editUserController->updateUser($id, $userData);
    
    if (is_string($result)) {
        $error = $result;
        $user = $editUserController->editUser($id);
        require 'Views/Eleve/edit_user_view.php';
    } else {
        header('Location: Views/Eleve/userListView.php?message=Utilisateur mis à jour avec succès');
        exit;
    }
} else {
    $id = $_GET['id'] ?? null;
    if ($id === null) {
        die("ID de l'utilisateur non spécifié");
    }
    
    try {
        $user = $editUserController->editUser($id);
        require 'Views/Eleve/edit_user_view.php';
    } catch (Exception $e) {
        $error = "Erreur : " . $e->getMessage();
        require 'Views/Eleve/edit_user_view.php';
    }
}