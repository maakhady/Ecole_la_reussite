<?php
class Users {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $mot_passe) {
        // Vérifier si l'email est enregistré
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $User = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Vérification si l'email existe
        if (!$User) {
            return 'email_incorrect'; // Retournez un message pour indiquer que l'email est incorrect
        }
    
        // Vérification du mot de passe entre par l utilisateur
        if (password_verify($mot_passe, $User['mot_passe'])) {
            return true; // ici le true renvoie au cas ou la Connexion réussie
        }
    
        return false; // ici le false renvoie au cas ou la connexion n a pas reussi
    }

}
?>
