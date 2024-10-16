<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$role= "Comptable";
// Inclusion des fichiers nécessaires
require_once '../../Models/espace_comptModel.php';
require_once '../../Controllers/espace_comptController.php';



require_once '../../Models/mensualiteModel.php';
require_once '../../Controllers/mensualiteController.php';

// Connexion à la base de données
$dsn = "mysql:host=localhost;dbname=ecole_la_reussite;charset=utf8";
$db = new PDO($dsn, 'root', '');

// Instancier le contrôleur
$controller = new ElevesController();


$id = isset($_GET['id']) ? $_GET['id'] : '';
$montant = isset($_GET['montant']) ? $_GET['montant'] : '';
$mode_paiement = isset($_GET['mode_paiement']) ? $_GET['mode_paiement'] : '';
$mois = isset($_GET['mois']) ? $_GET['mois'] : '';

$frais_id = isset($_GET['frais_id']) ? $_GET['frais_id'] : '';

if (!empty($id)) {
    $stmt = $db->prepare("SELECT matricule, nom, prenom, nom_tuteur, tel_tuteur, classe FROM eleves WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
}



if (isset($_GET['matricule'])) {
    $matricule = $_GET['matricule'];

    // Récupérer les informations de l'élève à partir du matricule
    $stmt = $db->prepare("SELECT matricule, nom, prenom, nom_tuteur, tel_tuteur, classe FROM eleves WHERE matricule = :matricule");
    $stmt->bindParam(':matricule', $matricule);
    $stmt->execute();
    $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recu Frais inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/La_reussite_academy-main/assets/css/stylerecu.css"> 
</head>
<body>

<div class="print-btn">
    <button class="imprimer-btn" onclick="window.print()">Imprimer le Reçu</button>
    <button class="retour-btn">
        <a href="espace_comptView.php" style="color: white; text-decoration: none;">Retour</a>
    </button>
</div> 
<!--reçu-->



   <div class="receipt">
   <div class="header">
    <img alt="Logo de l'école" height="100" src="../../assets/img/logo.png" width="100"/>
    <div class="title">
     <h1>
      Reçu Frais Mensualite
     </h1>
    </div>

   </div>
   <div class="info">
    <div class="row">
     <div>
      <strong>
       La Réussite Academy
      </strong>
      <br/>
      Adresse: Senegal Dakar
      <br/>
      Sacré coeur III
      <br/>
      Tel: +221 331236547
     </div>
     <div>
      <strong>
       Date:
      </strong>
      <?php echo date('d/m/Y'); ?>
      <br/>
      <strong>

       <strong>
    Numéro de reçu:
    <?php echo isset($_GET['frais_id']) ? htmlspecialchars($_GET['frais_id']) : 'N/A'; ?>
</strong>

      </strong>
      <?php isset($eleve['id']) ? htmlspecialchars($eleve['id']) : 'N/A'; ?>
     </div>
    </div>
    <div class="row">
     <div>
      <strong>
       Informations sur l'élève :
      </strong>
      <br/>
      <br>
      Nom de l'élève : <?= isset($eleve['nom']) ? htmlspecialchars($eleve['nom']) : 'N/A'; ?></p>

        Prenom de l'élève : <?= isset($eleve['prenom']) ? htmlspecialchars($eleve['prenom']) : 'N/A'; ?></p>


      Matricule : <?= (isset($eleve['matricule']) ? htmlspecialchars($eleve['matricule']) : 'N/A') . '</p>'; ?>

      Classe : <?=  (isset($eleve['classe']) ? htmlspecialchars($eleve['classe']) : 'N/A') . '</p>'; ?>
     </div>
     <div>

     <strong>
       Informations sur le tuteur :
      </strong>
      <br>
      Nom du parent/tuteur : <?=  (isset($eleve['nom_tuteur']) ? htmlspecialchars($eleve['nom_tuteur']) : 'N/A') . '</p>';?>
      <br/>
      Téléphone : <?=  (isset($eleve['tel_tuteur']) ? htmlspecialchars($eleve['tel_tuteur']) : '') . '</p>'; ?>

      <p><strong>Mois payé :</strong> <?php echo htmlspecialchars($mois); ?> </p>
     </div>
    </div>
   </div>
   <div class="payment-details">
    <table>
     <tr>
      <th>
       Détails du paiement :
      </th>
      <th>
      </th>
     </tr>
     <tr>
      <td>
      Frais mensualite
      </td>
      <td>
      <p><strong>Montant payé :</strong> <?php echo htmlspecialchars($montant); ?> CFA</p>
      </td>
     </tr>
     <tr>
      <td>
       Frais de mensualite :
      </td>
      <td>
      <p><strong>Montant payé :</strong> <?php echo htmlspecialchars($montant); ?> CFA</p>
      </td>
     </tr>
     <tr>
      <td>
       Mode de paiement
      </td>
      <td>
      <p><strong>Mode de paiement :</strong> <?php echo htmlspecialchars($mode_paiement); ?></p>
      </td>
     </tr>

     <tr>
      <td class="total">
       Total
      </td>
      <td class="total">
      <p><strong>Montant payé Total :</strong> <?php echo htmlspecialchars($montant); ?> CFA</p>
      </td>
     </tr>
    </table>
    <div class="amount-in-words">

    </div>
   </div>
   <div class="remarks">
    Remarques: Ce reçu doit être conservé pour toute future référence concernant l'inscription.
   </div>
   <div class="footer">
    Merci d'avoir inscrit votre enfant à l'École LA REUSSITE ACADEMY !


</div>

<!-- Le reste de votre reçu -->

<!-- Ajoutez l'image du cachet ici -->
<img class="cachet" src="../../assets/img/LA_réussite-removebg-preview (1).png" alt="Cachet de l'école">
</div>


</body>
</html>