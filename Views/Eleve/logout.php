<?php


// Détruire toutes les variables de session
$_SESSION = array();

// Si vous souhaitez détruire complètement la session, également effacer le cookie de session.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page de connexion ou d'accueil
header("Location: /../La_reussite_academy-main/Views/ConnexionView.php");
exit;
?>
