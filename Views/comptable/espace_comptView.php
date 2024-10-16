<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$role= "Comptable";
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
$id = isset($_GET['frais_id']) ? htmlspecialchars($_GET['frais_id']) : '';


// Gérer les requêtes POST (Enregistrement ou Suppression)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['action']) && $_POST['action'] === 'supprimer' && !empty($_POST['id'])) {
      // Supprimer les frais d'inscription
      $controller->supprimerFrais($_POST['id']);
  } else {
      // Enregistrer les frais d'inscription
      $data = [
          'id' => $_POST['id'],
          'classe' => $_POST['classe'],
          'montant' => $_POST['montant'],
          'mode_paiement' => $_POST['mode_paiement']
      ];

      // Vérification des données
      if (empty($data['id']) || empty($data['montant']) || empty($data['mode_paiement'])) {
          $error_message = "Veuillez remplir tous les champs obligatoires.";
      } else {
          $controller->enregistrerFrais($data);
      }
  }
}



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptable Liste</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/La_reussite_academy-main/assets/css/style.css"> 
    <script src="/La_reussite_academy-main/assets/javasc/stylefraisins.js"></script>

   
    <style>
      .btn[disabled] {
    opacity: 0.50;
    pointer-events: none;
}

.btn.disabled {
    opacity: 0.50;
    pointer-events: none; /* Désactive le clic sur le bouton */
}
    </style>
    
</head>
<body><div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <div class="text-center mb-4">
                <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark">
                    <svg class="me-2" width="52" height="40">
                        <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2" fill="none"/>
                        <text x="15" y="25" fill="black" font-size="12">D</text>
                    </svg> 
                    <h4><span class="fs-4" style="font-weight: bold; font-size: 1.5rem;"><?php echo $role; ?></span></h4>
                </div>     
            </div><br>
            <div class="d-grid gap-4">
                <button class="btn btn-success menu-button"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</button>
                <a href="/../La_reussite_academy-main/eleves.php"><button class="btn btn-success menu-button"><i class="fas fa-chalkboard-teacher"></i> Élèves</button></a>
                <a href="/../La_reussite_academy-main/index.php"><button class="btn btn-success menu-button"><i class="fas fa-user-graduate"></i> Utilisateurs</button></a> 
                <button class="btn  btn-success menu-button"><i class="fas fa-user"></i> Employer</button>          
                <button class="btn btn-success menu-button"><i class="fas fa-clipboard-list"></i> Présences</button>
                <button class="btn btn-success menu-button"><i class="fas fa-dollar-sign"></i> Salaire</button>
                <button class="btn btn-success menu-button"><i class="fas fa-calendar-alt"></i> Historique</button>
            
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light">
                <h2>Suivi de Payement des Élèves</h2>
                <div class="d-flex align-items-center">
                    <a href="/../La_reussite_academy-main/Views/ConnexionView.php" class="btn btn-danger mr-2">Déconnexion</a>
                    <div class="logo-container">
                        <img src="../../assets/img/logo.png?t=<? echo time(); ?>" alt="Logo" class="logo" style="width: 100px;">
                    </div>
                   
                </div>
               
            </div>
            

                    <!--la barre de rechercher-->
                    <div class="d-flex justify-content-between mb-4">
                <input type="text" class="form-control w-25" id="searchInput" placeholder="Rechercher " onkeyup="filterTable()">
            </div> 
            
            <!-- Section liste des élèves -->
             
            <h5 class="text-center mb-4">Liste des élèves</h5>
            <div class="bg-white p-4 rounded shadow">
            <div class="table-responsive">
                <table class="table table-striped"  id="studentsTable">
                    <thead>
                        <tr>
                            <th >Nom</th>
                            <th >Prénom</th>
                            <th >Matricule</th>
                            <th >Classe</th>
                            <th >Montant</th>
                            <th >Mois conserner</th>
                             <th>Status</th>
                            <th >Actions</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    // Fetch and display students
    $eleves = $controller->afficherEleves(); // Récupérer les élèves

    foreach ($eleves as $eleve) {
      $matricule = $eleve['matricule']; // Récupérer le matricule

      

      $statut_paiement = $controller->obtenirStatutPaiement($eleve['id']);

   
    // Si le mois n'est pas défini et que le statut est "Payé", on affiche "Frais d'inscription"
    $mois = isset($eleve['mois']) && !empty($eleve['mois']) ? htmlspecialchars($eleve['mois']) : (($statut_paiement === 'Payé') ? 'Frais d\'inscription' : '----');

     // Vérification et affichage du montant
$montant = isset($eleve['montant']) ? $eleve['montant'] : '----';


echo "<tr>
        <td>" . htmlspecialchars($eleve['nom']) . "</td>
        <td>" . htmlspecialchars($eleve['prenom']) . "</td>
        <td>" . htmlspecialchars($eleve['matricule']) . "</td>
        <td>" . htmlspecialchars($eleve['classe']) . "</td>
        <td>" . htmlspecialchars($montant) . "</td> <!-- Affichage du montant -->
        <td>" . htmlspecialchars($mois) . "</td>
        <td>" . htmlspecialchars($statut_paiement) . "</td>
        <td>";

// Si l'élève n'a pas encore payé, afficher uniquement le bouton "Inscrire"
if ($statut_paiement !== 'Payé') {
    echo "<a href='#' class='btn btn-sm btn-success  inscrire-btn' 
            data-bs-toggle='modal'
            data-bs-target='#inscriptionModal'
            data-id='" . htmlspecialchars($eleve['id']) . "' 
            data-nom='" . htmlspecialchars($eleve['nom']) . "' 
            data-prenom='" . htmlspecialchars($eleve['prenom']) . "' 
            data-matricule='" . htmlspecialchars($eleve['matricule']) . "' 
            data-classe='" . htmlspecialchars($eleve['classe']) . "'>
            Inscription
          </a>";
}

// Si l'élève a payé, afficher uniquement le bouton "Mensualité"
if ($statut_paiement === 'Payé') {
    echo "<a href='mensualiteView.php?matricule=" . htmlspecialchars($eleve['matricule']) . "' 
            class='btn btn-sm btn-success' title='Voir les mensualités'>
            Mensualité
          </a>";
}

echo "</td>
      <td>
        <form method='POST' style='display:inline;'>
            <input type='hidden' name='action' value='supprimer'>
            <input type='hidden' name='id' value='" . htmlspecialchars($eleve['id']) . "'>
            <button type='submit' class='btn btn-sm btn-danger' 
                onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer les frais pour cet élève ?');\">
                Supprimer
            </button>
        </form>
      </td>
    </tr>";

    }
    ?>
    
</tbody>

                </table>
            </div>
            
        </div>
         <!-- bouton pagination  -->
        <div id="pagination" class="text-center mt-4">   <button> </button></div>
    </div>
</div>

 




<!-- pour le Frais d'inscription -->
<div class="row justify-content-center">
    <div class="col-md-12 form-container">
        <div class="modal fade" id="inscriptionModal" tabindex="-1" aria-labelledby="inscriptionModalLabel" aria-hidden="true">

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inscriptionModalLabel">Frais d'inscription des Élèves</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="inscriptionForm">
        <input type="hidden" name="id" id="id">

          <div class="row mb-4">
            <div class="col-md-6">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" class="form-control" id="nom" name="nom" readonly>
            </div>
            <div class="col-md-6">
              <label for="prenom" class="form-label">Prénom</label>
              <input type="text" class="form-control" id="prenom" name="prenom" readonly>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6">
              <label for="matricule" class="form-label">Matricule</label>
              <input type="text" class="form-control" id="matricule" name="matricule" readonly>
            </div>
            <div class="col-md-6">
              <label for="classe" class="form-label">Classe</label>
              <input type="text" class="form-control" id="classe" name="classe" readonly>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6">
              <label for="mode_paiement" class="form-label">Mode de paiement</label>
              <select class="form-select" id="mode_paiement" name="mode_paiement">
                <option value="">Sélectionnez un Mode de paiement</option>
                <option value="Espèces">Espèces</option>
                <option value="Carte">Carte</option>
                <option value="Chèque">Chèque</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="montant" class="form-label">Montant</label>
              <input type="number" class="form-control" id="montant" name="montant" required>
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Enregistrer</button>
            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Retour</button>
          </div>
        </form>
      </div>
    </div>
  </div>
        </div>

</div>
</div>

<!-- Modal de confirmation personnalisé -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Confirmation du Paiement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="confirmationMessage"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" id="confirmPaymentButton" class="btn btn-success">Confirmer</button>
      </div>
    </div>
  </div>
</div>












<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>