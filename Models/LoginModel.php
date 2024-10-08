<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Méthode pour vérifier les informations de connexion
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe
        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }
}
