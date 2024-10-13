<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../Models/espace_comptModel.php'; // Corrigez le chemin ici
require_once __DIR__ . '/../Config/db.php'; // Incluez le fichier de configuration pour ROOT_PATH

class ElevesController {
    private $model;

    public function __construct() {
        // Création de l'instance de la base de données
        $database = new Database();
        $db = $database->dbConnexion(); // Obtenir la connexion

        // Passer la connexion au modèle
        $this->model = new ComptModel($db);
    }

    // Méthode pour afficher la liste des élèves
    public function afficherEleves() {
        // Appel à la méthode du modèle pour récupérer les élèves
        $eleves = $this->model->getAllEleves();
        return $eleves;
        // Inclure la vue pour afficher les élèves
        //require '../Views/comptable/espace_comptView.php'; // Utilisez ROOT_PATH pour un chemin relatif
    }
}
?>
