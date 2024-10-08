<?php
// Inclure la classe Database
require_once 'Database.php';

// Tester la connexion
$db = Database::getInstance(); // Utilisez getInstance() pour obtenir l'instance

if ($db) {
    echo "Connexion réussie à la base de données.<br>";

    // Lister les tables
    $tables = Database::getDatabaseTables(); // Utilisez la méthode statique pour obtenir les tables
    echo "Tables dans la base de données :<br>";
    
    if (!empty($tables)) {
        foreach ($tables as $table) {
            echo "- $table<br>";
        }
    } else {
        echo "Aucune table trouvée dans la base de données.";
    }
} else {
    echo "Échec de la connexion à la base de données.";
}
?>
