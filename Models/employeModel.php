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
    private $nom;
    private $prenom;
    private $date_naissance;
    private $email;
    private $telephone;
    private $role_id;
    private $mot_de_passe;
    private $matricule;
    private $date_embauche;

    public function __construct($nom, $prenom, $date_naissance, $email, $telephone, $role_id, $mot_de_passe = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date_naissance = $date_naissance;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->role_id = $role_id;
        $this->mot_de_passe = $mot_de_passe;
        $this->matricule = uniqid(); // Génération du matricule 
        $this->date_embauche = date('Y-m-d');
    }

    public function save() {
        $db = Database::getConnection();
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
}

?>