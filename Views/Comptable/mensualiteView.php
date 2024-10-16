<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once '../../Models/mensualiteModel.php';
require_once '../../Controllers/mensualiteController.php';

// Connexion à la base de données
$dsn = "mysql:host=localhost;dbname=ecole_la_reussite;charset=utf8";
$db = new PDO($dsn, 'root', '');

// Instancier le contrôleur
$controller = new PaiementController($db);

// Appeler la méthode pour enregistrer le paiement
$controller->enregistrerPaiement();

$message ='';
?>


<?php

if (isset($_GET['matricule'])) {
    $matricule = $_GET['matricule'];

}
if (!empty($id)) {
    $stmt = $db->prepare("SELECT matricule, nom, prenom, nom_tuteur, tel_tuteur, classe FROM eleves WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
}


?>



<?php
// Ici, vous pouvez ajouter toute logique PHP nécessaire, comme la récupération des données depuis une base de données
$role = "COMPTABLE";


// // Assurez-vous que $users est défini et est un tableau
// if (!isset($users) || !is_array($users)) {
//     $users = [];
// }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - <?php echo $role; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">




    <link rel="stylesheet" href="/La_reussite_academy-main/assets/css/style.css"> 




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
                            <text x="15" y="25" fill="black" font-size="12">C</text>
                        </svg> 
                        <h5><span class="fs-4" style="font-weight: bold; font-size: 1.5rem;"></span><strong><?php echo $role; ?></strong></span> </h5>
                        
                    </div>
                    

                </div><br>
                <div class="d-grid gap-4">
                <button class="btn btn-success menu-button"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</button>
            <a href="/La_reussite_academy-main/Views/Comptable/escape_comptView.php"><button class="btn btn-success menu-button "><i class="fas fa-chalkboard-teacher"></i> Paiements Élèves</button></a>
            <a href="/La_reussite_academy-main/Views/Employe/PaiementPersonnelView.php"><button class="btn btn-success menu-button "><i class="fas fa-users"></i> Paiements Personnel</button></a>
                <button class="btn  btn-success menu-button"><i class="fas fa-user"></i> Paiements Enseignant</button>          
                <button class="btn btn-success menu-button"><i class="fas fa-clipboard-list"></i> Présences</button>
                <button class="btn btn-success menu-button"><i class="fas fa-dollar-sign"></i> Salaire</button>
                <button class="btn btn-success menu-button"><i class="fas fa-calendar-alt"></i> Historique</button>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light">
                    <h2>Paiement Mensualité</h2>
                    <div class="d-flex align-items-center">
                        <a href="logout.php" class="btn btn-danger mr-2">Déconnexion</a>
                        <div class="logo-container">
                            <img src="../../assets/img/logo.png" alt="Logo" class="logo" style="width: 100px;">
                        </div>
                    </div>
                </div>

                <div class="container mt-5" >
        <h1 class="text-center mb-4">Paiement des frais de Mensualité</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="post" >
            <input type="hidden" name="id" value="<?= htmlspecialchars($eleve['id']) ?>">
<div class="pt">
            <div class="mb-3">
                <label for="matricule" class="form-label">Matricule</label>
                <input type="text" class="form-control" id="matricule" name="matricule" value="<?php echo $matricule; ?>" readonly>
            </div>
            </div>
            <div class="mb-3">
             <label for="mois" class="form-label">Mois</label>
            <select class="form-select" id="mois" name="mois" required>
                <option value="">Sélectionner un mois</option>
               <option value="Janvier">Janvier</option>
               <option value="Fevrier">Février</option>
              <option value="Mars">Mars</option>
              <option value="Avril">Avril</option>
             <option value="Mai">Mai</option>
             <option value="Juin">Juin</option>
             <option value="Juillet">Juillet</option>
             <option value="Aout">Août</option>
             <option value="Septembre">Septembre</option>
            <option value="Octobre">Octobre</option>
            <option value="Novembre">Novembre</option>
            <option value="Decembre">Décembre</option>
        </select>
</div>

            <div class="mb-3">
                <label for="montant" class="form-label">Montant</label>
                <input type="number" class="form-control" id="montant" name="montant" value="">
            </div>

            <div class="mb-3">
    <label for="mode_de_paiement" class="form-label">Mode de paiement</label>
    <select class="form-select" id="mode_de_paiement" name="mode_de_paiement" required>
        <option value="">Sélectionner un mode de paiement</option>
        <option value="Especes">Especes</option>
        <option value="Carte">WAVE</option>
    </select>
</div>

            <div class="mb-3">
                <label for="date_de_paiement" class="form-label">Date de paiement</label>
                <input type="date" class="form-control" id="date_de_paiement" name="date_de_paiement" value="">
            </div>
<div class="button">
            
            <div class="d-grid">
                <button type="submit" class="btn btn-success">  Enregistrer</a></button>
            </div>
            <div class="d-grid ">
                
        <a href="escape_comptView.php" class="btn btn-danger">Annuler</a></button>
            </div>
            </div>
        </form>
    </div>









            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
