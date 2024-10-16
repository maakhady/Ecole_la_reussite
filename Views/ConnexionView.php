<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// session_start();

// if (!isset($_SESSION['user_id'])) {
//     // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
//     header("Location: /../La_reussite_academy-main/Views/ConnexionView.php");
//     exit;
// }



require_once '../Config/db.php'; 
require_once '../Models/usersModel.php'; 
require_once '../Controllers/users.php'; 

// Créer une instance de Database et récupérer la connexion
$database = new Database();
$pdo = $database->dbConnexion();

// Créer une instance du modèle Users
$userModel = new Users($pdo);

// Créer une instance du contrôleur
$controller = new UserController($userModel);

// Initialiser les messages d'erreur
$emailError = ''; 
$passwordError = '';

// Appeler la méthode de connexion
$controller->connexion();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/La_reussite_academy-main/assets/css/style3.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <form action="" method="post" class="mt-5">
                <div class="text-center mb-4">
                    <img src="../assets/img/logo.png" alt="logo réussite" width="200">
                </div>
                <div class="p-3 mb-2">
                    <h1>Connexion</h1>
                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" class="form-control">
                        <small class="text-danger"><?php echo $emailError; ?></small> <!-- Message d'erreur ici -->
                    </div>
                    <div class="form-group">
    <label for="mot_passe">Mot de passe</label>
    <div class="input-group">
        <input type="password" id="mot_passe" name="mot_passe" class="form-control">
        <div class="input-group-append">
            <span class="input-group-text" id="togglePassword">
                <i class="fas fa-eye"></i>
            </span>
        </div>
    </div>
    <small class="text-danger"><?php echo $passwordError; ?></small>
</div>

                    <button type="submit" class="btn btn-success btn-block">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../assets/javasc/script.js"></script>
</body>
</html>