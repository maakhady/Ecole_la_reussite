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

$frais_id = isset($_GET['frais_id']) ? $_GET['frais_id'] : '';

if (!empty($id)) {
    $stmt = $db->prepare("SELECT matricule, nom, prenom, nom_tuteur, tel_tuteur, classe FROM eleves WHERE id = :id");
    $stmt->bindParam(':id', $id);
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
    <link rel="stylesheet" href="../../assets/css/style4.css">
    <style>
      body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f5f5f5;
}
.receipt {
    width: 800px;
    background-color: #ffffff;
    border: 1px solid #ddd;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 10px;
}
.header img {
    width: 80px;
}
.header .title {
    text-align: center;
    flex-grow: 1;
}
.header .title h1 {
    margin: 0;
    color: #18BE78;
}
.info, .payment-details, .footer {
    margin-bottom: 20px;
}
.info .row, .payment-details .row {
    display: flex;
    justify-content: space-between;
}
.info .row div, .payment-details .row div {
    width: 48%;
}
.payment-details table {
    width: 100%;
    border-collapse: collapse;
}
.payment-details table, .payment-details th, .payment-details td {
    border: 1px solid #ddd;
}
.payment-details th, .payment-details td {
    padding: 10px;
    text-align: left;
}
.payment-details th {
    background-color: #f5f5f5;
}
.total {
    text-align: right;
    font-weight: bold;
}
.amount-in-words {
    margin-top: 10px;
    font-weight: bold;
}
.remarks {
    margin-top: 20px;
    font-style: italic;
}
.footer {
    text-align: center;
    color: #18BE78;
    font-weight: bold;
}
.stamp {
    position: absolute;
    bottom: 20px;
    right: 20px;
    width: 100px;
    opacity: 0.5;
}

    /* Styliser les boutons */
    .print-btn button {
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        margin: 5px;
    }

    /* Bouton "Imprimer" avec couleur verte */
    .print-btn .imprimer-btn {
        background-color: #18BE78; /* Vert */
        color: white;
        border-radius: 5px;
    }

    /* Bouton "Retour" avec couleur rouge */
    .print-btn .retour-btn {
        background-color: #e74c3c; /* Rouge */
        color: white;
        border-radius: 5px;
    }

    /* Masquer les boutons lors de l'impression */
    @media print {
        .print-btn {
            display: none;
        }
    }

.print-btn{
    margin-top: 46%;
   
}
   </style>
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
      Reçu Frais d'Inscription
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
      Frais Inscription
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
   
    
   

</body>
</html>