<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__DIR__) . "/Models/PaiementModel.php");

class PaiementController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
        session_start(); // Assurez-vous que la session est démarrée
    }

    public function afficherPersonnelAPayer() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $mois = isset($_GET['mois']) ? $_GET['mois'] : '';
        $recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';

        try {
            $personnel = $this->model->getPersonnelAPayer($page, $mois, $recherche);
            $totalPages = $this->model->getTotalPages($mois, $recherche);

            require 'Views/Employe/PaiementPersonnelView.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors du chargement des données : ' . $e->getMessage();
            header('Location: index.php?action=afficherPersonnelAPayer');
            exit;
        }
    }

    public function detailsPaiementPersonnel() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $employe = $this->model->getEmployeDetails($id);

        if (!$employe) {
            $_SESSION['error'] = 'Aucun employé trouvé.';
            header('Location: index.php?action=afficherPersonnelAPayer');
            exit;
        }

        include dirname(__DIR__) . '/Views/Employe/DetailsPaiementView.php';
    }

    public function effectuerPaiement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employeId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $mois = $_POST['mois'] ?? '';
            $modePaiement = $_POST['mode_paiement'] ?? '';
            $montant = $_POST['montant'] ?? 0;

            try {
                $succes = $this->model->enregistrerPaiement($employeId, $mois, $modePaiement, $montant);

                if ($succes) {
                    $_SESSION['message'] = 'Paiement effectué avec succès';
                } else {
                    $_SESSION['error'] = 'Erreur lors de l\'enregistrement du paiement';
                }
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erreur lors de l\'enregistrement : ' . $e->getMessage();
            }

            header('Location: index.php?action=afficherPersonnelAPayer');
            exit;
        }
    }

    private function genererPagination($page, $totalPages) {
        $html = '<ul class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $page) ? 'active' : '';
            $html .= "<li class='page-item {$activeClass}'><a class='page-link' href='index.php?action=afficherPersonnelAPayer&page={$i}'>{$i}</a></li>";
        }
        $html .= '</ul>';
        return $html;
    }
}
?>
