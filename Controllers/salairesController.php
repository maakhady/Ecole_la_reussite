<?php
require_once 'Models/salairesModel.php';

class SalairesController {
    
    public $salairesModel;

    public function __construct($pdo) {
        $this->salairesModel = new salairesModel($pdo);
    }

    public function listSalaires() {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $salairesParPage = 10;   // Nombre d'employés par page

            $employes = $this->salairesModel->getAllSalaires($page, $salairesParPage);
            // $totalEmployes = $this->salairesModel->getTotalEmployes();
            
            //$totalPages = ceil($totalEmployes / $employesParPage);
            // Si $users n'est pas défini ou vide, on l'initialise comme un tableau vide
            if (empty($salaires)) {
                $salaires = [];
            }

            include('Views/Employe/salairesView.php');
        } catch (Exception $e) {
            /*$this->handleError($e, 'Une erreur est survenue lors de la récupération des employés.');
            $this->redirect('index.php?action=listEmployes');*/

            error_log($e->getMessage(), 3, 'logs/errors.log');
            var_dump('ERROR'. $e->getMessage() .'');
            echo 'Une erreur est survenue. Veuillez réessayer plus tard.';
        }
    }

    public function ajouterSalaire() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->afficherFormulaireEnregistrementSalaire();
            return;
        }

        try {
            $data = $this->validateAndSanitizeSalaireData($_POST);
            $result = $this->salairesModel->createSalaire($data);

            if ($result) {
                $_SESSION['message'] = 'Employé ajouté avec succès.';
                $this->redirect('index.php?action=listeEmployes');
            } else {
                throw new Exception("Échec de l'insertion dans la base de données.");
            }
        } catch (Exception $e) {
            $this->handleError($e, 'Une erreur est survenue lors de l\'ajout de l\'employé.');
            $this->redirect('index.php?action=inscriptionEmploye');
        }
    }

    public function afficherFormulaireEnregistrementSalaire() {
        include('Views/Employe/ajout_salaireView.php');
    }


    public function showUpdateSalaireForm($id) {
        try {
            $employe = $this->salairesModel->getSalaireById($id);
            if (!$employe) {
                throw new Exception("Employé non trouvé.");
            }
            include('Views/Employe/edit_employeView.php');
        } catch (Exception $e) {
            $this->handleError($e, 'Une erreur est survenue lors de la récupération des informations de l\'employé.');
            $this->redirect('index.php?action=listeEmployes');
        }
    }

    public function updateSalaire($id, $salaireData) {
        try {
            $currentSalaire = $this->salairesModel->getSalaireById($id);
            if (!$currentSalaire) {
                throw new Exception("Employé non trouvé.");
            }

            $data = $this->validateAndSanitizeSalaireData($salaireData);
            
            // Vérifier si des modifications ont été apportées
            $modifications = false;
            foreach ($data as $key => $value) {
                if ($currentSalaire[$key] != $value) {
                    $modifications = true;
                    break;
                }
            }

            if (!$modifications) {
                $_SESSION['message'] = 'Aucune modification n\'a été apportée.';
                $this->redirect('index.php?action=showUpdateEmployeForm&id=' . $id);
                return;
            }

            $result = $this->salairesModel->updateSalaire($id, $data);

            if ($result) {
                $_SESSION['message'] = 'Employé mis à jour avec succès.';
                $this->redirect('index.php?action=listeEmployes');
            } else {
                throw new Exception("Échec de la mise à jour dans la base de données.");
            }
        } catch (Exception $e) {
            $this->handleError($e, 'Une erreur est survenue lors de la mise à jour de l\'employé.');
            $this->redirect('index.php?action=showUpdateEmployeForm&id=' . $id);
        }
    }

    private function validateAndSanitizeSalaireData($data) {
        $sanitizedData = [];
        $requiredFields = ['montant', 'date_revision'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                throw new Exception("Le champ $field est obligatoire.");
            }
            $sanitizedData[$field] = $this->sanitizeInput($data[$field]);
        }

        if (!$this->validateDate($sanitizedData['date_revision'])) {
            throw new Exception('Format de date de revision invalide.');
        }

        return $sanitizedData;
    }

    private function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    private function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    private function handleError(Exception $e, $userMessage) {
        error_log($e->getMessage() . "\n" . $e->getTraceAsString(), 3, 'logs/errors.log');
        $_SESSION['error'] = $userMessage;
        if (defined('DEBUG_MODE') && DEBUG_MODE) {
            $_SESSION['debug_error'] = $e->getMessage() . "\n" . $e->getTraceAsString();
        }
    }

    private function redirect($location) {
        header("Location: $location");
        exit();
    }
    
}