<?php
require_once './Config/database.php';
require_once './Models/UserModel.php';
require_once './Controllers/UserController.php';

session_start();

function redirectWithMessage($url, $message, $type = 'success') {
    $_SESSION['flash_message'] = ['type' => $type, 'message' => $message];
    header("Location: $url");
    exit();
}

$pdo = getPDO(); // Assurez-vous que cette fonction existe dans database.php
$userModel = new UserModel($pdo);
$userController = new UserController($userModel);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_user = intval($_GET['id']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $result = $userController->archiveUser($id_user);
            if ($result) {
                redirectWithMessage('index.php?action=listUsers', "L'utilisateur a été archivé avec succès.");
            } else {
                throw new Exception("Échec de l'archivage de l'utilisateur.");
            }
        } catch (Exception $e) {
            redirectWithMessage('index.php?action=listUsers', "Erreur : " . $e->getMessage(), 'error');
        }
    } else {
        // Récupérer les informations de l'utilisateur pour l'affichage
        try {
            $user = $userController->getUserById($id_user);
            if (!$user) {
                throw new Exception("Utilisateur non trouvé.");
            }
        } catch (Exception $e) {
            redirectWithMessage('index.php?action=listUsers', "Erreur : " . $e->getMessage(), 'error');
        }

        // Afficher la page de confirmation
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirmer l'archivage - <?php echo htmlspecialchars($user['nom'] ?? ''); ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h1 class="card-title">Confirmer l'archivage</h1>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Êtes-vous sûr de vouloir archiver l'utilisateur : <strong><?php echo htmlspecialchars($user['nom'] ?? ''); ?></strong> ?</p>
                        <form method="post">
                            <button type="submit" class="btn btn-danger">Oui, archiver</button>
                            <a href="index.php?action=listUsers" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
} else {
    redirectWithMessage('index.php?action=listUsers', "ID d'utilisateur non valide.", 'error');
}
?>