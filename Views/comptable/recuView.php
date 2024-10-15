<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




$matricule = $_GET['matricule'] ?? '';
$montant = $_GET['montant'] ?? '';
$mode_paiement = $_GET['mode_paiement'] ?? '';
$nom = $_GET['nom'] ?? '';
$prennom = $_GET['premom'] ?? '';


if (isset($_GET['matricule'])) {
   $matricule = $_GET['matricule'];

}
if (isset($_GET['nom'])) {
   $nom = $_GET['nom'];
}
if (isset($_GET['prenom'])) {
   $prenom = $_GET['prenom'];
}
if (isset($_GET['mois'])) {
   $mois = $_GET['mois'];
}







?>

<!---*********************************************************LE RECU**********************************************************************-->
<html>
 <head>
    <link rel="stylesheet" href="../../assets/css/style4.css">
  <title>
   Reçu Frais d'Inscription
  </title>
 
 </head>
 <body>
  <div class="receipt">
   <div class="header">
    <img alt="Logo de l'école" height="80" src="logo.png" width="80"/>
    <div class="title">
     <h1>
      Reçu Frais d'Inscription
     </h1>
    </div>
    <button class="print-button" id="downloadButton">
     Imprimer
    </button>
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
       Numéro de reçu:
      </strong>
      <?php isset($eleve['id']) ? htmlspecialchars($eleve['id']) : 'N/A'; ?>
     </div>
    </div>
    <div class="row">
     <div>
      <p>      <strong>
       Informations sur l'élève :
      </strong>
      <br/>
      </p>

      Nom de l'élève :  <?php echo " " . htmlspecialchars($nom) .    htmlspecialchars($prenom) .   "<br>";  ?>

      <br/>
      Matricule :<strong> <?php echo " " . htmlspecialchars($matricule) .   "<br>";  ?> </strong>    
      <br/>
      Classe : 
      <br/>
     </div>
     <div>
      Nom du parent/tuteur :  <?php echo " " . htmlspecialchars($prenom) .   "<br>";  ?>
      <br/>
      Mois paye :  <strong>  <?php echo " " . htmlspecialchars($mois) .   "<br>";  ?></strong>
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
       Montant payé
      </td>
      <td>
      <?php echo " " . htmlspecialchars($montant) .  'FCFA'. "<br>";  ?>  
      </td>
     </tr>
     <tr>
      <td>
       Frais de mensualite :
      </td>
      <td>
      <?php echo " " . htmlspecialchars($montant) .  'FCFA'. "<br>";  ?>  
      </td>
     </tr>
     <tr>
      <td>
       Mode de paiement
      </td>
      <td>
      <?php echo "  " . htmlspecialchars($mode_paiement) . "<br>";?>
      </td>
     </tr>
    
     <tr>
      <td class="total">
       Total
      </td>
      <td class="total">
      <?php echo " " . htmlspecialchars($montant) .  'FCFA'. "<br>";  ?>  
      </td>
     </tr>
    </table>
    <div class="amount-in-words">
    
    FCFA
    </div>
   </div>
   <div class="remarks">
    Remarques: Ce reçu doit être conservé pour toute future référence concernant l'inscription.
   </div>
   <div class="footer">
    Merci d'avoir inscrit votre enfant à l'École LA REUSSITE ACADEMY !
   
 </body>
</html>

