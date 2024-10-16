<?php
require_once 'Models/elevesModel.php';

class EleveController {
    private $eleveModel;

    public function __construct($pdo) {
        $this->eleveModel = new EleveModel($pdo);
    }

    public function listEleves() {
        try {
            $eleves = $this->eleveModel->getAllEleves();
            include('Views/Eleve/eleveListView.php');
        } catch (Exception $e) {
            $this->handleError($e, 'Une erreur est survenue lors de la récupération des élèves.');
            $this->redirect('index.php');
        }
    }

    public function afficherFormulaireInscription() {
        include('Views/Eleve/inscription_eleveView.php');
    }

    public function ajouterEleve() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->afficherFormulaireInscription();
            return;
        }

        try {
            $data = $this->validateAndSanitizeEleveData($_POST);
            $result = $this->eleveModel->createEleve($data);

            if ($result) {
                $_SESSION['message'] = 'Élève ajouté avec succès.';
                $this->redirect('eleves.php');
            } else {
                throw new Exception("Échec de l'insertion dans la base de données.");
            }
        } catch (Exception $e) {
            $this->handleError($e, 'Une erreur est survenue lors de l\'ajout de l\'élève.');
            $this->redirect('index.php?action=inscriptionEleve');
        }
    }

    public function showUpdateEleveForm($id) {
        try {
            $eleve = $this->eleveModel->getEleveById($id);
            if (!$eleve) {
                throw new Exception("Élève non trouvé.");
            }
            include('Views/Eleve/edit_eleveView.php');
        } catch (Exception $e) {
            $this->handleError($e, 'Une erreur est survenue lors de la récupération des informations de l\'élève.');
            $this->redirect('index.php?action=listEleves');
        }
    }

    public function updateEleve($id, $eleveData) {
        try {
            $currentEleve = $this->eleveModel->getEleveById($id);
            if (!$currentEleve) {
                throw new Exception("Élève non trouvé.");
            }

            $data = $this->validateAndSanitizeEleveData($eleveData);
            
            // Vérifier si des modifications ont été apportées
            $modifications = false;
            foreach ($data as $key => $value) {
                if ($currentEleve[$key] != $value) {
                    $modifications = true;
                    break;
                }
            }

            if (!$modifications) {
                $_SESSION['message'] = 'Aucune modification n\'a été apportée.';
                $this->redirect('index.php?action=showUpdateEleveForm&id=' . $id);
                return;
            }

            $result = $this->eleveModel->updateEleve($id, $data);

            if ($result) {
                $_SESSION['message'] = 'Élève mis à jour avec succès.';
                $this->redirect('index.php?action=listEleves');
            } else {
                throw new Exception("Échec de la mise à jour dans la base de données.");
            }
        } catch (Exception $e) {
            $this->handleError($e, 'Une erreur est survenue lors de la mise à jour de l\'élève.');
            $this->redirect('index.php?action=showUpdateEleveForm&id=' . $id);
        }
    }

    private function validateAndSanitizeEleveData($data) {
        $sanitizedData = [];
        $requiredFields = ['nom', 'prenom', 'date_naissance', 'nom_tuteur', 'tel_tuteur', 'email_tuteur', 'departement', 'classe'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                throw new Exception("Le champ $field est obligatoire.");
            }
            $sanitizedData[$field] = $this->sanitizeInput($data[$field]);
        }

        if (!$this->validateDate($sanitizedData['date_naissance'])) {
            throw new Exception('Format de date invalide.');
        }

        if (!filter_var($sanitizedData['email_tuteur'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Format d\'email invalide.');
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