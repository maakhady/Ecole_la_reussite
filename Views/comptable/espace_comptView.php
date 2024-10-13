<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion des fichiers nécessaires
require_once '../../Models/espace_comptModel.php';
require_once '../../Controllers/espace_comptController.php';

// Connexion à la base de données
$dsn = "mysql:host=localhost;dbname=ecole_la_reussite;charset=utf8";
$db = new PDO($dsn, 'root', '');

// Instancier le contrôleur
$controller = new ElevesController();

// Appeler la méthode pour afficher la liste des élèves
$controller->afficherEleves();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style0.css"> 
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <div class="text-center mb-4">
                <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark">
                    <svg class="me-2" width="52" height="40">
                        <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2" fill="none"/>
                        <text x="15" y="25" fill="black" font-size="12">D</text>
                    </svg> 
                </div>     
            </div><br>
            <div class="d-grid gap-4">
                <button class="btn btn-success menu-button"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</button>
                <button class="btn btn-success menu-button"><i class="fas fa-user-graduate"></i> Utilisateurs</button>            
                <button class="btn btn-success menu-button"><i class="fas fa-chalkboard-teacher"></i> Élèves</button>
                <button class="btn btn-success menu-button"><i class="fas fa-book"></i> Cours</button>
                <button class="btn btn-success menu-button"><i class="fas fa-clipboard-list"></i> Présences</button>
                <button class="btn btn-success menu-button"><i class="fas fa-clipboard"></i> Notes</button>
                <button class="btn btn-success menu-button"><i class="fas fa-calendar-alt"></i> Emplois du temps</button>
                <button class="btn btn-success menu-button"><i class="fas fa-dollar-sign"></i> Comptabilité</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light">
                <h2>Tableau de Bord</h2>
                <div class="d-flex align-items-center">
                    <a href="/../La_reussite_academy-main/Views/ConnexionView.php" class="btn btn-danger mr-2">Déconnexion</a>
                    <div class="logo-container">
                        <img src="../assets/img/logo.png" alt="Logo" class="logo" style="width: 100px;">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-4">
                <input type="text" class="form-control w-25" id="searchInput" placeholder="Rechercher " onkeyup="filterTable()">
            </div> 

            <!-- Section liste des élèves -->
            <h5 class="text-center mb-4">Liste des élèves</h5>
            <div class="table-responsive">
                <table class="table table-bordered" id="studentsTable">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Matricule</th>
                            <th>Classe</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Afficher les élèves
                    $eleves = $controller->afficherEleves(); // Récupérer les élèves
                    foreach ($eleves as $eleve) {
                        $matricule = $eleve['matricule']; // Récupérer le matricule
                        echo "<tr>
                                <td>{$eleve['nom']}</td>
                                <td>{$eleve['prenom']}</td>
                                <td>{$eleve['matricule']}</td>
                                <td>{$eleve['classe']}</td>
                                <td>
                                    <a href='inscrire.php?matricule=$matricule' class='btn btn-primary'>Inscription</a>
                                    <a href='mensualiteView.php?matricule=$matricule' class='btn btn-warning'>Mensualité</a>
                                </td>
                              </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<script src="../../assets/javasc/script.js"></script>
</body>
</html>
