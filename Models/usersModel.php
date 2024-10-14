

<?php
class Users {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $mot_passe) {
        // Vérifier si l'email est enregistré
        $query = "SELECT * FROM users WHERE email = :email AND (role_id = 1 OR role_id = 2)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $User = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Vérification si l'email existe
        if (!$User) {
            return 'email_incorrect'; // Retournez un message pour indiquer que l'email est incorrect
        }
    
        // Vérification du mot de passe fourni par l'utilisateur
        if (password_verify($mot_passe, $User['mot_passe'])) {
            return $User; // Retourner l'utilisateur complet pour récupérer le rôle
        }
    
        return 'mot_de_passe_incorrect'; // Message d'erreur pour mot de passe incorrect
    }
}
?>
