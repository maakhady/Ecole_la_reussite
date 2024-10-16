<?php
$role= "Directeur";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription des élèves - <?php echo $role; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/La_reussite_academy-main/assets/css/style.css">    
    <style>
        .error-message {
            color: rgba(212, 60, 60, 0.959);
            font-size: 12px;
            margin-top: 5px;
            display: block;
        } 
        .sidebar {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .main-content {
            padding: 20px;
        }
        .custom-bg {
            background-color: #f8f9fa;
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
                    <h4><span class="fs-4" style="font-weight: bold; font-size: 1.5rem;"><?php echo $role; ?></span></h4>
                </div>     
            </div><br>
            <div class="d-grid gap-4">
                <button class="btn btn-success menu-button"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</button>
                <a href="/La_reussite_academy-main/index.php"><button class="btn btn-success menu-button"><i class="fas fa-user-graduate"></i> Utilisateurs</button>  </a>          
                <button class="btn link btn-success menu-button"><i class="fas fa-chalkboard-teacher"></i> Élèves</button>
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
                <h2>Inscription d'un Élève</h2>
                <div class="d-flex align-items-center">
                    <a href="/La_reussite_academy-main/logout.php" class="btn btn-danger mr-2">Déconnexion</a>
                    <div class="logo-container">
                        <img src="/La_reussite_academy-main/assets/img/logo.png" alt="Logo" class="logo" style="width: 100px;">
                    </div>
                </div>
            </div>

            <div class="custom-bg p-4 rounded shadow">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" id="eleveForm". >
                    
                <div class="row mb-3">
                    <div class=" col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" >
                        <div id="nomError" class="error-message"></div>
                    </div>

                    <div class=" col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom"  >
                        <div id="prenomError" class="error-message"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="mb-3 col-md-6">
                        <label for="date_naissance" class="form-label">Date de Naissance</label>
                        <input type="date" class="form-control" id="date_naissance" name="date_naissance" min="2005-01-01" max="2017-01-01" >
                        <div id="dateNaissanceError" class="error-message"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="nom_tuteur" class="form-label">Nom du Tuteur</label>
                        <input type="text" class="form-control" id="nom_tuteur" name="nom_tuteur" >
                        <div id="nomTuteurError" class="error-message"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="mb-3 col-md-6">
                        <label for="tel_tuteur" class="form-label">Téléphone du Tuteur</label>
                        <input type="number" class="form-control" id="tel_tuteur" name="tel_tuteur"  min="700000000" max="789999999" placeholder="00-000-00-00" >
                        <div id="telTuteurError" class="error-message"></div>
                    </div>
               
                    <div class="mb-3 col-md-6">
                        <label for="email_tuteur" class="form-label">Email du Tuteur</label>
                        <input type="email" class="form-control" id="email_tuteur" name="email_tuteur"  >
                        <div id="emailTuteurError" class="error-message"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="mb-3 col-md-6">
                        <label for="departement" class="form-label">Département</label>
                        
                        <select class="form-select" id="departement" name="departement" >
                            <option value="">Sélectionnez un département</option>
                            <option value="primaire">Primaire</option>
                            <option value="secondaire">Secondaire</option>
                        </select>
                        <div id="departementError" class="error-message"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="classe" class="form-label">Classe</label>
                        <select class="form-select" id="classe" name="classe" >
                            <option selected disabled>Sélectionnez une classe</option>
                        </select>
                        <div id="classeError" class="error-message"></div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="submit" class="btn  btn-lg btn-green d-grid gap-2 col-3 mx-auto">Ajouter</button>
                        <a href="eleves.php"><button type="button" class="btn btn-danger ">Retour</button></a>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
         document.getElementById('departement').addEventListener('change', function() {
            var departement = this.value;
            var classeSelect = document.getElementById('classe');
            classeSelect.innerHTML = '<option selected disabled>Sélectionnez une classe</option>'; // Efface les options existantes

            if (departement === 'primaire') {
                classeSelect.innerHTML += '<option value="CI">CI</option>';
                classeSelect.innerHTML += '<option value="CP">CP</option>';
                classeSelect.innerHTML += '<option value="CE1">CE1</option>';
                classeSelect.innerHTML += '<option value="CE2">CE2</option>';
                classeSelect.innerHTML += '<option value="CM1">CM1</option>';
                classeSelect.innerHTML += '<option value="CM2">CM2</option>';
            } else if (departement === 'secondaire') {
                classeSelect.innerHTML += '<option value="6E">6ème</option>';
                classeSelect.innerHTML += '<option value="5E">5ème</option>';
                classeSelect.innerHTML += '<option value="4E">4ème</option>';
                classeSelect.innerHTML += '<option value="3E">3ème</option>';
            }
        });
        function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

document.addEventListener("DOMContentLoaded", function() {
    const fieldsToCapitalize = ['nom', 'prenom', 'nom_tuteur'];

    fieldsToCapitalize.forEach(function(fieldId) {
        const field = document.getElementById(fieldId);
        field.addEventListener('blur', function() {
            field.value = capitalizeFirstLetter(field.value); });
    });
});
        document.getElementById('eleveForm').addEventListener('submit', function(event) {
            // Empêcher la soumission par défaut si des erreurs existent
            let formIsValid = true;

            // Effacer les messages d'erreur précédents
            document.querySelectorAll('.error-message').forEach(el => el.innerHTML = '');

            // Validation des champs
            const nom = document.getElementById('nom').value.trim();
    const nomRegex = /^[a-zA-ZÀ-ÿ '-]+$/; // Permettre lettres, espaces, apostrophes et traits d'union
    if (nom === '') {
        document.getElementById('nomError').innerText = 'Le nom est obligatoire.';
        formIsValid = false;
    } else if (!nomRegex.test(nom)) {
        document.getElementById('nomError').innerText = 'Le nom ne peut contenir que des lettres.';
        formIsValid = false;
    }
    const prenom = document.getElementById('prenom').value.trim();
    if (prenom === '') {
        document.getElementById('prenomError').innerText = 'Le prénom est obligatoire.';
        formIsValid = false;
    } else if (!nomRegex.test(prenom)) {
        document.getElementById('prenomError').innerText = 'Le prénom ne peut contenir que des lettres.';
        formIsValid = false;
    }
    // Validation de la date de naissance
    const date_naissance = document.getElementById('date_naissance').value;
    const minDate = new Date('2005-01-01');
    const maxDate = new Date('2017-01-01');
    if (date_naissance === '') {
        document.getElementById('dateNaissanceError').innerText = 'La date de naissance est obligatoire.';
        formIsValid = false;
    } else {
        const dateNaissanceObj = new Date(date_naissance);
        if (dateNaissanceObj < minDate || dateNaissanceObj > maxDate) {
            document.getElementById('dateNaissanceError').innerText = 'La date de naissance doit être comprise entre le 01/01/2005 et le 01/01/2017.';
            formIsValid = false;
        }
    }
    const nom_tuteur = document.getElementById('nom_tuteur').value.trim();
    if (nom_tuteur === '') {
        document.getElementById('nomTuteurError').innerText = 'Le nom du tuteur est obligatoire.';
        formIsValid = false;
    } else if (!nomRegex.test(nom_tuteur)) {
        document.getElementById('nomTuteurError').innerText = 'Le nom du tuteur ne peut contenir que des lettres.';
        formIsValid = false;
    }
            const email_tuteur = document.getElementById('email_tuteur').value.trim();
            if (email_tuteur === '' || !/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email_tuteur)) {
                document.getElementById('emailTuteurError').innerText = 'L\'email du tuteur est obligatoire et doit être valide.';
                formIsValid = false;
            }

            const departement = document.getElementById('departement').value.trim();
            if (departement === '') {
                document.getElementById('departementError').innerText = 'Le département est obligatoire.';
                formIsValid = false;
            }

            const classe = document.getElementById('classe').value.trim();
            if (classe === '') {
                document.getElementById('classeError').innerText = 'La classe est obligatoire.';
                formIsValid = false;
            }

            if (!formIsValid) {
                event.preventDefault();
            }
        });
    </script>
</script>
</body>
</html>