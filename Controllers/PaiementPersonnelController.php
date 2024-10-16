<?php
require_once '../../Models/PaiementPersonnelModel.php';
require_once 'BulletinPaieGenerator.php';

class PaiementPersonnelController {
    private $paiementPersonnelModel;
    private $bulletinPaieGenerator;
    private $itemsPerPage = 10;
    private $moisValides = [
        'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',
        'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'
    ];
    private $modesValides = ['Wave', 'Especes'];

    public function __construct($pdo) {
        $this->paiementPersonnelModel = new PaiementPersonnelModel($pdo);
    }

    public function getPaiementsData($page = 1) {
        try {
            $page = max(1, filter_var($page, FILTER_VALIDATE_INT));
            $paiements = $this->paiementPersonnelModel->getPaiements($page, $this->itemsPerPage);
            $totalPaiements = $this->paiementPersonnelModel->getTotalPaiements();
            $totalPages = ceil($totalPaiements / $this->itemsPerPage);

            return [
                'paiements' => $paiements,
                'totalPages' => $totalPages
            ];
        } catch (Exception $e) {
            error_log("Erreur dans getPaiementsData: " . $e->getMessage());
            return ['error' => "Une erreur est survenue lors de la récupération des données."];
        }
    }

    public function effectuerPaiement() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->prepareErrorResponse("Méthode non autorisée");
        }

        $data = $this->sanitizeInput([
            'user_id' => $_POST['user_id'] ?? '',
            'role' => $_POST['role'] ?? '',
            'mois' => $_POST['mois'] ?? '',
            'mode_paiement' => $_POST['mode_paiement'] ?? '',
            'montant' => $_POST['montant'] ?? '',
            'statut_paiement' => 'Payé'
        ]);

        error_log("Données reçues dans effectuerPaiement : " . print_r($data, true));

        if (!$this->validateData($data)) {
            return $this->prepareErrorResponse("Données invalides ou manquantes.");
        }

        if (!$this->isValidMonth($data['mois'])) {
            return $this->prepareErrorResponse("Le mois sélectionné n'est pas valide : " . $data['mois']);
        }

        if (!in_array($data['mode_paiement'], $this->modesValides)) {
            return $this->prepareErrorResponse("Le mode de paiement sélectionné n'est pas valide. Mode reçu : " . $data['mode_paiement']);
        }

        $data['mois'] = $this->convertirMoisEnNumero($data['mois']);

        try {
            $salaireBrut = $this->paiementPersonnelModel->getSalaireBrut($data['role']);
            if ($salaireBrut === null) {
                throw new Exception("Impossible de trouver le salaire brut pour le rôle : " . $data['role']);
            }

            if (abs(floatval($data['montant']) - floatval($salaireBrut)) > 0.01) {
                return $this->prepareErrorResponse("Le montant saisi (" . $data['montant'] . ") ne correspond pas au salaire brut (" . $salaireBrut . ") pour ce rôle.");
            }

            $result = $this->paiementPersonnelModel->effectuerPaiement($data);

            if ($result['success']) {
                return $this->prepareSuccessResponse("Paiement effectué avec succès");
            } else {
                $errorMessage = is_array($result['errors']) ? implode(', ', $result['errors']) : $result['errors'];
                throw new Exception($errorMessage);
            }
        } catch (Exception $e) {
            error_log("Erreur dans effectuerPaiement: " . $e->getMessage());
            return $this->prepareErrorResponse($e->getMessage());
        }
    }

    private function validateData($data) {
        return !empty($data['user_id']) && !empty($data['role']) && 
               !empty($data['mois']) && !empty($data['mode_paiement']) && 
               !empty($data['montant']) && is_numeric($data['montant']);
    }

    private function sanitizeInput($data) {
        return array_map(function($value) {
            if (is_string($value)) {
                return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            }
            return $value;
        }, $data);
    }

    private function isValidMonth($month) {
        return in_array($month, $this->moisValides);
    }

    private function convertirMoisEnNumero($mois) {
        $numeroMois = array_search($mois, $this->moisValides) + 1;
        return date('Y') . '-' . str_pad($numeroMois, 2, '0', STR_PAD_LEFT);
    }

    private function prepareErrorResponse($message) {
        return ['success' => false, 'message' => $message];
    }

    private function prepareSuccessResponse($message) {
        return ['success' => true, 'message' => $message];
    }

    public function getPaiementById($id) {
        try {
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id === false) {
                throw new Exception("ID de paiement invalide");
            }
            return $this->paiementPersonnelModel->getPaiementById($id);
        } catch (Exception $e) {
            error_log("Erreur dans getPaiementById: " . $e->getMessage());
            return null;
        }
    }
    public function supprimerPaiement($id) {
        try {
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id === false) {
                throw new Exception("ID de paiement invalide");
            }
    
            $this->paiementPersonnelModel->supprimerPaiement($id);
            return $this->prepareSuccessResponse("Paiement supprimé avec succès");
        } catch (Exception $e) {
            error_log("Erreur dans supprimerPaiement: " . $e->getMessage());
            return $this->prepareErrorResponse($e->getMessage());
        }
    }
}