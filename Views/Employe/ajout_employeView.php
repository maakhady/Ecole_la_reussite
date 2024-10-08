<?php
// Assurez-vous que $users est défini et est un tableau
if (!isset($users) || !is_array($users)) {
    $users = [];
}
$role = "Directeur";
$eleves = 10000;
$enseignants = 60;
$employes = 60;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - <?php echo $role; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
<style>
.error-message {
    color: rgba(212, 60, 60, 0.959);
    font-size: 12px;
    margin-top: 5px;
    display: block;
    } 
</style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <div class="text-center mb-4">
                <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark">
                    <svg class="me-2" width="52" height="40">
                        <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2" fill="none"/>
                        <text x="15" y="25" fill="black" font-size="12">D</text>
                    </svg> 
                    <h4><span class="fs-4" style="font-weight: bold; font-size: 1.5rem;"></span><?php echo $role; ?></span></h4>
                </div>     
            </div><br>
            <div class="d-grid gap-4">
                <button class="btn btn-success menu-button"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</button>
                <button class="btn link btn-success menu-button"><i class="fas fa-user-graduate"></i> Utilisateurs</button>            
                <a href="/../La_reussite_academy-main/eleves.php"><button class="btn  btn-success menu-button"><i class="fas fa-chalkboard-teacher"></i> Élèves</button></a>
                <button class="btn btn-success menu-button"><i class="fas fa-book"></i> Cours</button>
                <button class="btn btn-success menu-button"><i class="fas fa-clipboard-list"></i> Présences</button>
                <button class="btn btn-success menu-button"><i class="fas fa-clipboard"></i> Notes</button>
                <button class="btn btn-success menu-button"><i class="fas fa-calendar-alt"></i> Emplois du temps</button>
                <button class="btn btn-success menu-button"><i class="fas fa-dollar-sign"></i> Comptabilité</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light">
                <h2>Tableau de Bord</h2>
                <div class="d-flex align-items-center">
                    <a href="/../La_reussite_academy-main/Views/ConnexionView.php" class="btn btn-danger mr-2">Déconnexion</a>
                    <div class="logo-container">
                        <img src="logo.png" alt="Logo" class="logo" style="width: 100px;">
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <h5>ELEVES</h5>
                        <p class="text-primary fs-4"><?php echo number_format($eleves); ?></p>
                        <small>Elèves enregistrés</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <h5>ENSEIGNANTS</h5>
                        <p class="text-primary fs-4"><?php echo $enseignants; ?></p>
                        <small>Enseignants enregistrés</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <h5>AUTRES EMPLOYES</h5>
                        <p class="text-primary fs-4"><?php echo $employes; ?></p>
                        <small>Employés enregistrés</small>
                    </div>
                </div>
            </div>

            <!-- Formulaire d'enregistrement -->
            <div class="custom-bg p-4 rounded shadow ">
                <h5 class="text-center mb-4">Enregistrement d'un nouvel employé</h5>
                <form class="row gy-3 needs-validation" id="myForm" method="POST" action="../../Controllers/employe.php">
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" id="name">
                        <span class="error-message" id="error-name"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" id="prenom" >
                        <span class="error-message" id="error-prenom"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input type="date" name="date_naissance" class="form-control" id="date"  max="2006-01-31">
                        <span class="error-message" id="error-date"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email">
                        <span class="error-message" id="error-email"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" name="telephone" class="form-control" id="phone" min="700000000" max="789999999">
                        <span class="error-message" id="error-phone"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="form-label">Rôle</label>
                        <select name="role_id" id="role" class="form-select" aria-label="Veuillez choisir une fonction" required>
                            <option selected disabled>Veuillez choisir une fonction</option>
                            <option value="6">Gardien</option>
                            <option value="7">Jardinier</option>
                            <option value="8">Technicien de surface</option>
                            <option value="2">Directeur</option>
                            <option value="1">Comptable</option>
                            <option value="5">Surveillant</option>
                        </select>
                        <span class="error-message" id="error-role"></span>
                    </div>
                    <div id="mot_de_passe_section" class="col-md-6" style="display: none;">
                        <label for="mot_de_passe" class="form-label">Mot de passe</label>
                        <input type="password" name="mot_de_passe" class="form-control" id="password">
                        <span class="error-message" id="error-password"></span>
                    </div>
                    <div class="col-12 text-center">
                        <button class="btn btn-success" type="submit">Enregistrer</button>
                        <a href="/../La_reussite_academy-main/index.php" class="btn btn-danger mr-2">Retour</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('role').addEventListener('change', function() {
        var role = this.value;
        var passwordSection = document.getElementById('mot_de_passe_section');
        if (role == '1' || role == '2' || role == '3') {
            passwordSection.style.display = 'block';
        } else {
            passwordSection.style.display = 'none';
        }
    });
    document.getElementById("myForm").addEventListener("submit", function(event) {
    // Empêche la soumission par défaut du formulaire
    event.preventDefault();
    
    // Réinitialise les messages d'erreur
    document.getElementById("error-name").textContent = "";
    document.getElementById("error-email").textContent = "";
    document.getElementById("error-prenom").textContent = "";
    document.getElementById("error-phone").textContent = "";
    document.getElementById("error-role").textContent = "";
    document.getElementById("error-password").textContent = "";
    document.getElementById("error-date").textContent = "";
    
    // Récupère les valeurs des champs
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let firstname = document.getElementById("prenom").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let role = document.getElementById("role").value;
    let password = document.getElementById("password").value;
    let date = document.getElementById("date").value;
    
    // Initialise un booléen pour suivre les erreurs
    let hasError = false;

    // Validation du nom
    if (name === "") {
        document.getElementById("error-name").textContent = "Le nom est requis.";
        hasError = true;
    }
    if (firstname === "") {
        document.getElementById("error-prenom").textContent = "Le prenom est requis.";
        hasError = true;
    }

    if (phone === "") {
        document.getElementById("error-phone").textContent = "Le numero de telephone est requis.";
        hasError = true;
    }

    if (role === "") {
        document.getElementById("error-role").textContent = "Le role est requis.";
        hasError = true;
    }

    if (password === "") {
        document.getElementById("error-password").textContent = "Le mot de passe est requis.";
        hasError = true;
    }

    if (date === "") {
        document.getElementById("error-date").textContent = "La date est requis.";
        hasError = true;
    }

    if (date > "2006-01-01") {
        document.getElementById("error-date").textContent = "La date est invalide.";
        hasError = true;
    }



    // Validation de l'email
    if (email === "") {
        document.getElementById("error-email").textContent = "L'email est requis.";
        hasError = true;
    } else if (!validateEmail(email)) {
        document.getElementById("error-email").textContent = "Veuillez entrer un email valide.";
        hasError = true;
    }

    // Si aucune erreur, on soumet le formulaire
    if (!hasError) {
        // Simuler la soumission (remplacer par `this.submit();` pour une soumission réelle)
        alert("Le formulaire est valide et soumis !");
    }
});

// Fonction pour valider un email
function validateEmail(email) {
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

</script>
</body>
</html>