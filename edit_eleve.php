<?php
require_once __DIR__ .'/Config/database.php';
require_once __DIR__ . '/Models/EditEleveModel.php';
require_once __DIR__ . '/Controllers/EditEleveController.php';

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
$editEleveModel = new EditEleveModel($pdo);
$editEleveController = new EditEleveController($editEleveModel);

if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['update'])) {
    $id = $_POST['id'] ?? null;
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
    ];
    
    $result = $editEleveController->updateEleve($id, $eleveData);
    
    if (is_string($result)) {
        $error = $result;
        $error = $result;
        $eleve = $editEleveController->editEleve($id);
        require 'Views/Eleve/edit_eleve_view.php';
    } else {
        header('Location: Views/Eleve/eleveListView.php?message=Élève mis à jour avec succès');
        exit;
    }
} else {
    $id = $_GET['id'] ?? null;
    
    if ($id === null) {
        die("ID de l'élève non spécifié");
    }
    
    try {
        $eleve = $editEleveController->editEleve($id);
        require 'Views/Eleve/edit_eleve_view.php';
    } catch (Exception $e) {
        $error = "Erreur : " . $e->getMessage();
        require 'Views/Eleve/edit_eleve_view.php';
    }
}