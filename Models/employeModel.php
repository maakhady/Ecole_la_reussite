<?php

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

    public function __construct($nom, $prenom, $date_naissance, $email, $telephone, $role_id, $matieres = [], $classe = null, $mot_de_passe = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date_naissance = $date_naissance;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->role_id = $role_id;
        $this->mot_de_passe = $mot_de_passe ? password_hash($mot_de_passe, PASSWORD_DEFAULT) : null; // Hachage du mot de passe
        $this->matricule = uniqid(); // Génération du matricule 
        $this->date_embauche = date('Y-m-d');
        $this->matieres = $matieres; 
        $this->classe = $classe;    
    }

    public function save() {
        $db = Database::getConnection();

        // Vérification de l'existence de l'email
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

            $stmt->execute();
            $userId = $db->lastInsertId(); // Récupérer l'ID du nouvel utilisateur

            // Enregistrement supplémentaire pour les professeurs
            if ($this->role_id == self::ROLE_PROFESSEUR) {
                if (count($this->matieres) > 2) {
                    throw new Exception("Un professeur ne peut enregistrer que deux matières.");
                }

                if (count(array_unique($this->matieres)) < count($this->matieres)) {
                    throw new Exception("Les matières ne doivent pas être identiques.");
                }

                $this->saveProfessor($userId);
            }

            // Enregistrement supplémentaire pour les enseignants
            if ($this->role_id == self::ROLE_ENSEIGNANT) {
                $this->saveTeacher($userId);
            }

            $db->commit(); // Valider la transaction
        } catch (Exception $e) {
            $db->rollBack(); // Annuler la transaction en cas d'erreur
            throw $e; // Relancer l'exception pour traitement
        }
    }

    public static function exists($email) {
        $db = Database::getConnection();
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public static function validate($nom, $prenom, $date_naissance, $email, $telephone, $role_id, $mot_de_passe = null) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "L'adresse email est invalide.";
        }

        if ($role_id <= 5 && empty($mot_de_passe)) {
            return "Le mot de passe est requis pour ce rôle.";
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
                $this->saveProfessorMatiere($professeurId, $matiereId); // Lier le professeur à ses matières
            }
        }
    }
    
    private function saveMatiere($matiere) {
        $db = Database::getConnection();
        
        // Insertion des matières dans la table matieres
        $query = "INSERT INTO matieres (nom_matieres) VALUES (:nom_matieres)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nom_matieres', $matiere);
        $stmt->execute();
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
    
        if ($result) {
            return $result['id']; // Renvoyer l'ID de la matière existante
        } else {
            // Si la matière n'existe pas, l'insérer et renvoyer son ID
            $this->saveMatiere($matiere);
            return $db->lastInsertId(); // Renvoyer l'ID de la nouvelle matière
        }
    }
}
?>