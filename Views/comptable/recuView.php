<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
      <strong>
       Informations sur l'élève :
      </strong>
      <br/>
      Nom de l'élève : <?= isset($eleve['nom']) ? htmlspecialchars($eleve['nom']) : 'N/A'; ?></p>

      <br/>
      Matricule : <?= (isset($eleve['matricule']) ? htmlspecialchars($eleve['matricule']) : 'N/A') . '</p>'; ?>
      <br/>
      Classe : <?=  (isset($eleve['classe']) ? htmlspecialchars($eleve['classe']) : 'N/A') . '</p>'; ?>
     </div>
     <div>
      Nom du parent/tuteur : <?=  (isset($eleve['nom_tuteur']) ? htmlspecialchars($eleve['nom_tuteur']) : 'N/A') . '</p>';?>
      <br/>
      Téléphone : <?=  (isset($eleve['telephone']) ? htmlspecialchars($eleve['telephone']) : 'N/A') . '</p>'; ?>
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
      <?= isset($eleve['montant']) ? htmlspecialchars($eleve['montant']) : 'N/A'; ?>  FCFA
      </td>
     </tr>
     <tr>
      <td>
       Frais de mensualite :
      </td>
      <td>
      <?= isset($eleve['montant']) ? htmlspecialchars($eleve['montant']) : 'N/A'; ?>
      </td>
     </tr>
     <tr>
      <td>
       Mode de paiement
      </td>
      <td>
      <?= isset($eleve['mode_paiement']) ? htmlspecialchars($eleve['mode_paiement']) : 'N/A'; ?>
      </td>
     </tr>
    
     <tr>
      <td class="total">
       Total
      </td>
      <td class="total">
      <?php isset($eleve['montant']) ? htmlspecialchars($eleve['montant']) : 'N/A'; ?> FCFA
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

