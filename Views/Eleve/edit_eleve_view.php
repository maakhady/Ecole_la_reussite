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
                <button class="btn link btn-success menu-button"><i class="fas fa-user-graduate"></i> Utilisateurs</button>            
                <button class="btn btn-success menu-button"><i class="fas fa-chalkboard-teacher"></i> Élèves</button>
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
                    <a href="Views/ConnexionView.php" class="btn btn-danger mr-2">Déconnexion</a>
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
                    <form action="/edit_eleve.php? echo time(); ?>" method="POST">
                        <div class="form-row">
                            <!-- <div class="form-group col-md-6">
                                <label for="matricule">Matricule</label>
                                <input type="text" class="form-control" id="matricule" name="matricule" required>
                            </div> -->   
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($eleve['nom']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($eleve['prenom']) ?>" required>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom_tuteur">Nom du Tuteur</label>
                            <input type="text" class="form-control" id="nom_tuteur" name="nom_tuteur" value="<?= htmlspecialchars($eleve['nom_tuteur']) ?>"required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tel_tuteur">Téléphone du Tuteur</label>
                            <input type="tel" class="form-control" id="tel_tuteur" name="tel_tuteur"value="<?= htmlspecialchars($eleve['tel_tuteur']) ?>" required>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email_tuteur">Email du Tuteur</label>
                                <input type="email" class="form-control" id="email_tuteur" name="email_tuteur" value="<?= htmlspecialchars($eleve['email_tuteur']) ?>"required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_naissance">Date de Naissance</label>
                                <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($eleve['date_naissance']) ?>"required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="departement">Département</label>
                                <select class="form-control" id="departement" name="departement" required>
                                    <option value="<?= htmlspecialchars($eleve['departement']) ?>"></option>
                                    <option value="Primaire">Primaire</option>
                                    <option value="Secondaire">Secondaire</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="classe">Classe</label>
                                <select class="form-control" id="classe" name="classe" required>
                                    <option value="<?= htmlspecialchars($eleve['classe']) ?>"></option>
                                    <option value="CI">CI</option>
                                    <option value="CP">CP</option>
                                    <option value="CE1">CE1</option>
                                    <option value="CE2">CE2</option>
                                    <option value="CM1">CM1</option>
                                    <option value="CM2">CM2</option>
                                    <option value="6e">6e</option>
                                    <option value="5e">5e</option>
                                    <option value="4e">4e</option>
                                    <option value="3e">3e</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success">Ajouter l'Élève</button>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>