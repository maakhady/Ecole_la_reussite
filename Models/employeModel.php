<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Connexion à la base de données
class Database {
    private static $host = 'localhost';
    private static $dbname = 'ecole_la_reussite';
    private static $username = 'root';
    private static $password = '';
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            try {
                $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$dbname . ';charset=utf8';
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                self::$connection = new PDO($dsn, self::$username, self::$password, $options);
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }
        return self::$connection;
    }
}

// Classe User (Modèle)
class User {
    const ROLE_PROFESSEUR = 3;
    const ROLE_ENSEIGNANT = 4;

    private $nom;
    private $prenom;
    private $date_naissance;
    private $email;
    private $telephone;
    private $role_id;
    private $mot_de_passe;
    private $matricule;
    private $date_embauche;
    private $classe;
    private $matieres;
    private $id;

    public function __construct($nom, $prenom, $date_naissance, $email, $telephone, $role_id, $matieres = [], $classe = null, $mot_de_passe = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date_naissance = $date_naissance->format('Y-m-d');
        $this->email = $email;
        $this->telephone = $telephone;
        $this->role_id = $role_id;
        $this->mot_de_passe = $mot_de_passe ? password_hash($mot_de_passe, PASSWORD_DEFAULT) : null; // Hachage du mot de passe
        $this->date_embauche = date('Y-m-d');
        $this->matieres = $matieres; 
        $this->classe = $classe;
        $this->matricule = uniqid();
    }

    public function save() {
        $db = Database::getConnection();
    
        if (self::exists($this->email)) {
            throw new Exception("L'email existe déjà.");
        }
    
        $db->beginTransaction();
        try {
            $query = "INSERT INTO users (role_id, matricule, nom, prenom, date_naissance, telephone, email, mot_passe, date_embauche, archivage)
                      VALUES (:role_id, :matricule, :nom, :prenom, :date_naissance, :telephone, :email, :mot_passe, :date_embauche, 0)";
    
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':date_naissance', $this->date_naissance);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':telephone', $this->telephone);
            $stmt->bindParam(':role_id', $this->role_id);
            $stmt->bindParam(':matricule', $this->matricule);
            $stmt->bindParam(':mot_passe', $this->mot_de_passe);
            $stmt->bindParam(':date_embauche', $this->date_embauche);
            

            // Exécutez la requête
            $stmt->execute();
            $this->id = $db->lastInsertId(); // Récupérer l'ID du nouvel utilisateur
            
            // Génération du matricule après l'insertion
            $this->matricule = $this->generateMatricule();

            // Mise à jour du matricule dans la base de données
            $sqlUpdate = "UPDATE users SET matricule = :matricule WHERE id = :id";
            $stmtUpdate = $db->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':matricule', $this->matricule);
            $stmtUpdate->bindParam(':id', $this->id);
            $stmtUpdate->execute();

            // Enregistrement supplémentaire pour les professeurs
            if ($this->role_id == self::ROLE_PROFESSEUR) {
                $this->saveProfessor($this->id);
            }

            // Enregistrement supplémentaire pour les enseignants
            if ($this->role_id == self::ROLE_ENSEIGNANT) {
                $this->saveTeacher($this->id);
            }

            $db->commit(); // Valider la transaction
            return true; // Retourner true en cas de succès
        } catch (Exception $e) {
            $db->rollBack(); // Annuler la transaction en cas d'erreur
            throw $e; // Relancer l'exception pour traitement
        }
    }

    public function generateMatricule() {
        // Générer le matricule 
        return 'RA' . $this->role_id . ($this->id * 2);
    }

    public static function exists($email) {
        $db = Database::getConnection();
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    public static function exisTtel($telephone) {
        $db = Database::getConnection();
        $query = "SELECT COUNT(*) FROM users WHERE telephone = :telephone";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public static function validate($nom, $prenom, $date_naissance, $email, $telephone, $role_id, $mot_de_passe = null) {
        if (empty($nom) || empty($prenom) || empty($date_naissance) || empty($telephone)) {
            return "Tous les champs doivent être remplis.";
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "L'adresse email est invalide.";
        }

        if (($role_id == '1' || $role_id == '2' || $role_id == '3'|| $role_id == '4' || $role_id == '5') && empty($mot_de_passe)){
            return "Le mot de passe est requis";
        }

    
        return true; // Validation réussie
    }
    

    private function saveProfessor($userId) {
        $db = Database::getConnection();
        
        // Insertion dans la table professeurs
        $query = "INSERT INTO professeurs (user_id) VALUES (:user_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        $professeurId = $db->lastInsertId(); // Récupérer l'ID du professeur
        
        // Insertion des matières associées
        if (!empty($this->matieres)) {
            foreach ($this->matieres as $matiere) {
                $matiereId = $this->getMatiereId($matiere);
                if ($matiereId === null) {
                    $this->saveMatiere($matiere); // Insérer la matière
                    $matiereId = $this->getMatiereId($matiere); // Récupérer l'ID de la matière
                }
                $this->saveProfessorMatiere($professeurId, $matiereId); // Lier le professeur à ses matières
            }
        }
    }
    
    
    private function saveMatiere($matiere) {
        $db = Database::getConnection();
        
        try {
            // Insertion des matières dans la table matieres
            $query = "INSERT INTO matieres (nom_matieres) VALUES (:nom_matieres)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nom_matieres', $matiere);
            $stmt->execute();
        } catch (Exception $e) {
            // Enregistrer l'erreur ou la relancer
            throw new Exception("Erreur lors de l'enregistrement de la matière: " . $e->getMessage());
        }
    }
    

    private function saveTeacher($userId) {
        $db = Database::getConnection();
        
        // Insertion dans la table enseignants
        $query = "INSERT INTO enseignants (user_id, classe) VALUES (:user_id, :classe)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':classe', $this->classe);
        $stmt->execute();
    }

    private function saveProfessorMatiere($professeurId, $matiereId) {
        $db = Database::getConnection();
        
        // Insertion dans la table professeur_matiere
        $query = "INSERT INTO professeur_matiere (prof_id, matiere_id) VALUES (:prof_id, :matiere_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':prof_id', $professeurId); // Correction du paramètre ici
        $stmt->bindParam(':matiere_id', $matiereId);
        $stmt->execute();
    }

    private function getMatiereId($matiere) {
        $db = Database::getConnection();
        
        // Vérification si la matière existe déjà
        $query = "SELECT id FROM matieres WHERE nom_matieres = :nom_matieres";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nom_matieres', $matiere);
        $stmt->execute();
        $result = $stmt->fetch();
    
        return $result ? $result['id'] : null;
    }
}
?>
