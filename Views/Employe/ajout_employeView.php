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
    .sidebar {
            transition: all 0.3s;
            display: none; /* Cacher par défaut */
        }
        .sidebar.active {
            display: block; /* Afficher lorsqu'il est actif */
        }
        @media (min-width: 768px) {
            .sidebar {
                display: block; /* Afficher sur écrans plus grands */
            }
        }
        .menu-button {
            margin-top: 10px;
        }
</style>
</head>

<body>
<div class="container-fluid">
    <div class="row">

    <div class="col-md-2 d-md-none">
            <button class="btn btn-primary" id="menuToggle"><i class="fas fa-bars"></i></button>
        </div>

        <!-- Sidebar -->
        <div class="col-md-2 sidebar" id="sidebar">
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
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" id="name" autocomplete="Nom-de-famille">
                        <span class="error-message" id="error-name"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" id="prenom" autocomplete="Prenom">
                        <span class="error-message" id="error-prenom"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date de naissance</label>
                        <input type="date" name="date_naissance" class="form-control" id="date"   max="2016-12-31" >
                        <span class="error-message" id="error-date"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" autocomplete="Adresse-mail">
                        <span class="error-message" id="error-email"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="tel" name="telephone" class="form-control" id="phone" autocomplete="tel">
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
                            <option value="3">Professeur</option>
                            <option value="4">Enseignant</option>
                        </select>
                        <span class="error-message" id="error-role"></span>
                    </div>
                    <div id="mot_de_passe_section" class="col-md-6" style="display: none;">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                        <input type="password" name="mot_de_passe" class="form-control" id="password" autocomplete="Mot-de-passe">
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        </div>
                        <span class="error-message" id="error-password"></span>
                    </div>
                    <div id="teacher_section" class="col-md-6" style="display: none;">
                    
                            <!-- Champs pour les matieres -->
                            <div id="matiere-fields">
                                <div class="mb-3">
                                    <label for="matiere1" class="form-label">Matière 1</label>
                                    <select class="form-select" id="matiere1" name="matiere1">
                                        <option value="Maths">Maths</option>
                                        <option value="PC">PC</option>
                                        <option value="SVT">SVT</option>
                                        <option value="Anglais">Anglais</option>
                                        <option value="Français">Français</option>
                                        <option value="HG">Histoire-Géographie</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="matiere2" class="form-label">Matière 2</label>
                                    <select class="form-select" id="matiere2" name="matiere2">
                                        <option value="Maths">Maths</option>
                                        <option value="PC">PC</option>
                                        <option value="SVT">SVT</option>
                                        <option value="Anglais">Anglais</option>
                                        <option value="Français">Français</option>
                                        <option value="HG">Histoire-Géographie</option>
                                    </select>
                                    <span class="error-message" id="error-matiere2"></span>
                                </div>
                            </div>

                            <!-- Champ pour le choix de la classe, visible uniquement si niveau = primaire -->
                            <div id="classe-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="classe" class="form-label">Classe</label>
                                    <select class="form-select" id="classe" name="classe">
                                        <option value="CI">CI</option>
                                        <option value="CP">CP</option>
                                        <option value="CE1">CE1</option>
                                        <option value="CE2">CE2</option>
                                        <option value="CM1">CM1</option>
                                        <option value="CM2">CM2</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="col-12 text-center">
                        <button class="btn btn-success" type="submit">Enregistrer</button>
                        <a href="../../index.php" class="btn btn-danger mr-2">Retour</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('menuToggle').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active'); // Basculer la classe active
    });

    // Écouteur d'événements pour le changement du mot de passe
document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePasswordIcon');
    
    togglePassword.addEventListener("click", function () {
        // Bascule le type de l'input entre 'password' et 'text'
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    });
});



    document.getElementById('role').addEventListener('change', function() {
        var matiereFields = document.getElementById("matiere-fields");
        var classeFields = document.getElementById("classe-fields");

        var role = this.value;
        var passwordSection = document.getElementById('mot_de_passe_section');
        var teacherSection = document.getElementById('teacher_section');
        if (role == '1' || role == '2' || role == '3'|| role == '4' || role == '5') {
            passwordSection.style.display = 'block';
        } else {
            passwordSection.style.display = 'none';
        }
        if(role == '3'){
            teacherSection.style.display = 'block';
            matiereFields.style.display = 'block';
            classeFields.style.display = 'none';
        } else if(role == '4'){
            teacherSection.style.display = 'block';
            matiereFields.style.display = 'none';
            classeFields.style.display = 'block';
        } else {
            teacherSection.style.display = 'none';
        }
    });
    document.getElementById("myForm").addEventListener("submit", function(event) {
    // Empêche la soumission par défaut du formulaire
    // event.preventDefault();
    
    // Réinitialise les messages d'erreur
    document.getElementById("error-name").textContent = "";
    document.getElementById("error-email").textContent = "";
    document.getElementById("error-prenom").textContent = "";
    document.getElementById("error-phone").textContent = "";
    document.getElementById("error-role").textContent = "";
    document.getElementById("error-password").textContent = "";
    document.getElementById("error-date").textContent = "";
    document.getElementById("error-matiere2").textContent = "";
    
    // Récupère les valeurs des champs
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let firstname = document.getElementById("prenom").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let role = document.getElementById("role").value;
    let password = document.getElementById("password").value;
    let date = document.getElementById("date").value;
    let matiere1 = document.getElementById("matiere1").value;
    let matiere2 = document.getElementById("matiere2").value;
    
    // Initialise un booléen pour suivre les erreurs
    let hasError = false;

    let currentDate = new Date();
    let birthDate = new Date(date);
    let maxDate = new Date("2006-01-31");

    if (birthDate > maxDate) {
        document.getElementById("error-date").textContent = "La date de naissance ne doit pas être supérieure au 31 janvier 2006.";
        hasError = true;
    }

    if(matiere1 === matiere2){
        document.getElementById("error-matiere2").textContent = "Veuillez choisir deux matieres differentes";
        hasError = true;
    }

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

    if (role == '1' || role == '2' || role == '3'|| role == '4' || role == '5'){
    if (password === "") {
        document.getElementById("error-password").textContent = "Le mot de passe est requis.";
        hasError = true;
    }
}

    if(phone > 789999999 || phone < 700000000){
        document.getElementById("error-phone").textContent = "Numero de telephone non valide";
        hasError = true;
    }
    
    if (date === "") {
        document.getElementById("error-date").textContent = "La date est requis.";
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
        this.submit();
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