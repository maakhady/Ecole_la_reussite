<?php $role = "Directeur";?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Élève - <?php echo $role; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css?t=<? echo time(); ?>">
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
                    <h4><span class="fs-4" style="font-weight: bold; font-size: 1.5rem;"><?php echo $role; ?></span></h4>
                </div>     
            </div><br>
            <div class="d-grid gap-4">
                <button class="btn btn-success menu-button"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</button>
                
                <button class="btn btn-success menu-button"><i class="fas fa-user-graduate"></i> Utilisateurs</button>            
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
                <h2>Modifier un Élève</h2>
                <div class="d-flex align-items-center">
                    <a href="/logout.php" class="btn btn-danger mr-2">Déconnexion</a>
                    <div class="logo-container">
                        <img src="./assets/img/logo.png?t=<? echo time(); ?>" alt="Logo" class="logo" style="width: 100px;">
                    </div>
                </div>
            </div>

            <div class="custom-bg p-4 rounded shadow">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <?php if (isset($eleve)): ?>
                    <div class="bg-light p-4 rounded border border-primary">
                    <!-- <h5 class="text-center mb-4">Formulaire d'Ajout d'Élève</h5> -->
                    <form action="edit_eleve.php" method="POST" id="editEleveform" >
                        <div class="form-row">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($eleve['id']) ?>">
                            <!-- <div class="form-group col-md-6">
                                <label for="matricule">Matricule</label>
                                <input type="text" class="form-control" id="matricule" name="matricule" required>
                            </div> -->   
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($eleve['nom']) ?>" >
                                <span class="error-message" id="error-nom"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($eleve['prenom']) ?>" >
                                <span class="error-message" id="error-prenom"></span>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom_tuteur">Nom du Tuteur</label>
                            <input type="text" class="form-control" id="nom_tuteur" name="nom_tuteur" value="<?= htmlspecialchars($eleve['nom_tuteur']) ?>">
                            <span class="error-message" id="error-nom_tuteur"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tel_tuteur">Téléphone du Tuteur</label>
                            <input type="tel" class="form-control" id="tel_tuteur" name="tel_tuteur"value="<?= htmlspecialchars($eleve['tel_tuteur']) ?>"min="700000000" max="789999999" >
                            <span class="error-message" id="error-tel_tuteur"></span>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email_tuteur">Email du Tuteur</label>
                                <input type="email" class="form-control" id="email_tuteur" name="email_tuteur" value="<?= htmlspecialchars($eleve['email_tuteur']) ?>">
                                <span class="error-message" id="error-email_tuteur"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_naissance">Date de Naissance</label>
                                <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($eleve['date_naissance']) ?>"min="2005-01-01" max="2019-12-31">
                                <span class="error-message" id="error-date_naissance"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="departement">Département</label>
                                <select class="form-control" id="departement" name="departement" >
                                    <option value="<?= htmlspecialchars($eleve['departement']) ?>"></option>
                                    <option value="Primaire">Primaire</option>
                                    <option value="Secondaire">Secondaire</option>
                                </select>
                                <span class="error-message" id="error-departement"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="classe">Classe</label>
                                <select class="form-control" id="classe" name="classe" >
                                    <option value="<?= htmlspecialchars($eleve['classe']) ?>"></option>
                                    <span class="error-message" id="error-classe"></span>
                                </select>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" name='update'class="btn btn-success">Modifier</button>
                            <a href="eleves.php?action=listEleves" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
         document.getElementById('departement').addEventListener('change', function() {
            var departement = this.value;
            var classeSelect = document.getElementById('classe');
            classeSelect.innerHTML = '<option value="<?= htmlspecialchars($eleve['classe']) ?>"></option>'; // Efface les options existantes

            if (departement === 'Primaire') {
                classeSelect.innerHTML += '<option value="CI">CI</option>';
                classeSelect.innerHTML += '<option value="CP">CP</option>';
                classeSelect.innerHTML += '<option value="CE1">CE1</option>';
                classeSelect.innerHTML += '<option value="CE2">CE2</option>';
                classeSelect.innerHTML += '<option value="CM1">CM1</option>';
                classeSelect.innerHTML += '<option value="CM2">CM2</option>';
            } else if (departement === 'Secondaire') {
                classeSelect.innerHTML += '<option value="6E">6ème</option>';
                classeSelect.innerHTML += '<option value="5E">5ème</option>';
                classeSelect.innerHTML += '<option value="4E">4ème</option>';
                classeSelect.innerHTML += '<option value="3E">3ème</option>';
            }
        });
        function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

document.getElementById('editEleveform').addEventListener('submit', function(event) {
            // Empêcher la soumission par défaut si des erreurs existent
            let formIsValid = true;

            // Effacer les messages d'erreur précédents
            document.querySelectorAll('.error-message').forEach(el => el.innerHTML = '');

    
    // Réinitialise les messages d'erreur
    document.getElementById("error-nom").textContent = "";
    document.getElementById("error-email_tuteur").textContent = "";
    document.getElementById("error-prenom").textContent = "";
    document.getElementById("error-tel_tuteur").textContent = "";
    document.getElementById("error-nom_tuteur").textContent = "";
    document.getElementById("error-date_naissance").textContent = "";
    
    // Récupère les valeurs des champs
    let name = document.getElementById("nom").value.trim();
    let email = document.getElementById("email_tuteur").value.trim();
    let firstname = document.getElementById("prenom").value.trim();
    let phone = document.getElementById("tel_tuteur").value.trim();
    let name_parent = document.getElementById("nom_tuteur").value.trim();
    let date = document.getElementById("date_naissance").value;
    
    // Initialise un booléen pour suivre les erreurs
    let hasError = false;

    // Validation du nom
    if (name === "") {
        document.getElementById("error-nom").textContent = "Le nom est requis.";
        hasError = true;
    }
    if (firstname === "") {
        document.getElementById("error-prenom").textContent = "Le prenom est requis.";
        hasError = true;
    }

    if (phone === "") {
        document.getElementById("error-tel_tuteur").textContent = "Le numero de telephone du parent est requis.";
        hasError = true;
    }

    if (name_parent === "") {
        document.getElementById("error-nom_tuteur").textContent = "Le nom du parent est requis.";
        hasError = true;
    }

    if (date === "") {
        document.getElementById("error-date_naissance").textContent = "La date de naissance de l'élève est requis.";
        hasError = true;
    }

    if (date > "2006-01-01") {
        document.getElementById("error-date").textContent = "La date est invalide.";
        hasError = true;
    }



    // Validation de l'email
    if (email === "") {
        document.getElementById("error-email_tuteur").textContent = "L'email est requis.";
        hasError = true;
    } else if (!validateEmail(email)) {
        document.getElementById("error-email_tuteur").textContent = "Veuillez entrer un email valide.";
        hasError = true;
    }

    // Si aucune erreur, on soumet le formulaire
    if (!hasError) {
        // Simuler la soumission (remplacer par `this.submit();` pour une soumission réelle)
        alert("Le formulaire est valide et soumis !");
    }


// Fonction pour valider un email
function validateEmail(email) {
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
})
    </script>
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>