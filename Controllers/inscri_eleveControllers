<?php
require_once 'Model/incri_eleveModel.php';

class EleveController {
    private $eleveModel;

    public function __construct($pdo) {
        $this->eleveModel = new Eleve($pdo);
    }

    public function ajouterEleve() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Nettoyage et validation des données
            $nom = $this->sanitizeInput($_POST['nom']);
            $prenom = $this->sanitizeInput($_POST['prenom']);
            $date_naissance = $this->sanitizeInput($_POST['date_naissance']);
            $nom_tuteur = $this->sanitizeInput($_POST['nom_tuteur']);
            $tel_tuteur = $this->sanitizeInput($_POST['tel_tuteur']);
            $email_tuteur = $this->sanitizeInput($_POST['email_tuteur']);
            $departement = $this->sanitizeInput($_POST['departement']);
            $classe = $this->sanitizeInput($_POST['classe']);

            // Validation supplémentaire
            if (!$this->validateDate($date_naissance)) {
                $_SESSION['error'] = 'Format de date invalide.';
                $this->redirect('index.php?action=inscriptionEleve');
                return;
            }

            if (!filter_var($email_tuteur, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Format d\'email invalide.';
                $this->redirect('index.php?action=inscriptionEleve');
                return;
            }

            if ($this->allFieldsFilled([$nom, $prenom, $date_naissance, $nom_tuteur, $tel_tuteur, $email_tuteur, $departement, $classe])) {
                try {
                    $data = [
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'date_naissance' => $date_naissance,
                        'nom_tuteur' => $nom_tuteur,
                        'tel_tuteur' => $tel_tuteur,
                        'email_tuteur' => $email_tuteur,
                        'departement' => $departement,
                        'classe' => $classe
                    ];

                    $this->eleveModel->ajouterEleve($data);
                    $_SESSION['message'] = 'Élève ajouté avec succès.';
                    $this->redirect('index.php?action=inscriptionEleve');
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    $this->redirect('index.php?action=inscriptionEleve');
                }
            } else {
                $_SESSION['error'] = 'Tous les champs doivent être remplis.';
                $this->redirect('index.php?action=inscriptionEleve');
            }
        } else {
            // Afficher le formulaire d'inscription
            include 'Views/Eleve/inscription_eleveView.php';
        }
    }

    private function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    private function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    private function allFieldsFilled($fields) {
        return !in_array('', $fields, true);
    }

    private function redirect($location) {
        header("Location: $location");
        exit();
    }
}