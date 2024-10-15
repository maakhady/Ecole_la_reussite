<?php
class PaiementController {

    private $paiementModel;

    public function __construct($db) {
        // Initialiser le modèle avec la connexion à la base de données
        $this->paiementModel = new paiement_mensuel($db);
    }

    public function enregistrerPaiement() {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer les données du formulaire
            $matricule = $_POST['matricule'] ?? null;
            $mois = $_POST['mois'] ?? null;
            $montant = $_POST['montant'] ?? null;
            $mode_paiement = $_POST['mode_de_paiement'] ?? null;
            $date_inscription = $_POST['date_de_paiement'] ?? null;
            $date_modif = date('Y-m-d H:i:s'); // Mettre à jour la date de modification
            $nom = $_POST['nom'] ?? null; // Utiliser $_POST au lieu de $_GET
            $prenom = $_POST['prenom'] ?? null; 


            // Vérifier que toutes les données sont présentes
            if ($matricule && $mois && $montant && $mode_paiement && $date_inscription) {
                // Appeler la méthode du modèle pour enregistrer le paiement
                $result = $this->paiementModel->paiementmensuelParMatricule($matricule, $mois, $montant, $mode_paiement, $date_inscription, $date_modif);

                // Vérifier si l'enregistrement a réussi
                if ($result) {
                    echo "paiement effectue";
                    // Rediriger vers une page de succès ou afficher un message de succès
                    $message = "Paiement enregistré avec succès!";
                    header("Location: ../../Views/comptable/recuView.php?matricule=" . $matricule . "&montant=" . $montant . "&nom=" . $nom . "&prenom=" . $prenom ."&mois=" . $mois . "&mode_paiement=" . $mode_paiement);

                    exit();
                } else {
                    // Afficher un message d'erreur
                    $error = "Erreur lors de l'enregistrement du paiement.";
                }
            } else {
                // Afficher une erreur si des champs sont manquants
                $error = "Veuillez remplir tous les champs.";
            }
        }

        // Inclure la vue pour afficher le formulaire et les messages
        //include '../views/comptable/mensualiteview.php';
    }
}
?>
