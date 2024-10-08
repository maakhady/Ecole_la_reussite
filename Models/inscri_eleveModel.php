<?php

class Eleve {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function generateMatricule() {
        do {
            $matricule = 'ELV' . strtoupper(bin2hex(random_bytes(4)));
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM eleves WHERE matricule = :matricule');
            $stmt->execute(['matricule' => $matricule]);
            $count = $stmt->fetchColumn();
        } while ($count > 0);

        return $matricule;
    }

    public function ajouterEleve($data) {
        try {
            $this->pdo->beginTransaction();

            // Générer le matricule
            $data['matricule'] = $this->generateMatricule();

            // Vérifier si l'email du tuteur existe déjà dans la base de données
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM eleves WHERE email_tuteur = :email_tuteur');
            $stmt->execute(['email_tuteur' => $data['email_tuteur']]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                throw new Exception('Erreur : Un tuteur avec cet email existe déjà.');
            }

            // Si l'email n'existe pas, procéder à l'insertion
            $stmt = $this->pdo->prepare('INSERT INTO eleves (matricule, nom, prenom, date_naissance, nom_tuteur, tel_tuteur, email_tuteur, departement, classe)
                                         VALUES (:matricule, :nom, :prenom, :date_naissance, :nom_tuteur, :tel_tuteur, :email_tuteur, :departement, :classe)');
            $stmt->execute($data);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception('Erreur lors de l\'ajout de l\'élève : ' . $e->getMessage());
        }
    }
}