<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Enseignants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f1f1f1;
        }
        .sidebar {
            background-color: #00A96B;
            min-height: 100vh;
            padding: 20px;
            color: white;
        }
        .menu-button {
            background-color: transparent;
            color: white;
            font-weight: bold;
            border: none;
            text-align: left;
        }
        .menu-button i {
            margin-right: 10px;
        }
        .menu-button:hover {
            background-color: #007f50;
            color: white;
        }
        .main-content {
            padding: 20px;
            background-color: white;
            border-radius: 15px;
            margin: 20px;
        }
        .form-control, .form-select {
            border-radius: 10px;
        }
        .logo-container img {
            width: 120px;
        }
        .btn-success {
            background-color: #00A96B;
            border-color: #00A96B;
        }
        .btn-danger {
            background-color: #FF5656;
        }
        .form-container {
            background-color: #F8F9FA;
            padding: 20px;
            border-radius: 10px;
        }
        .form-label {
            font-weight: bold;
        }
        .header {
            background-color: #F8F9FA;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <div class="text-center mb-4">
                <img src="avatar.png" alt="Administrateur" class="rounded-circle" style="width: 100px;">
                <h4>Administrateur</h4>
            </div>
            <div class="d-grid gap-4">
                <button class="btn menu-button"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</button>
                <button class="btn menu-button"><i class="fas fa-user-graduate"></i> Élèves</button>
                <button class="btn menu-button"><i class="fas fa-chalkboard-teacher"></i> Enseignants</button>
                <button class="btn menu-button"><i class="fas fa-users"></i> Employés</button>
                <button class="btn menu-button"><i class="fas fa-book"></i> Cours</button>
                <button class="btn menu-button"><i class="fas fa-clipboard-list"></i> Présences</button>
                <button class="btn menu-button"><i class="fas fa-clipboard"></i> Notes</button>
                <button class="btn menu-button"><i class="fas fa-calendar-alt"></i> Emplois du temps</button>
                <button class="btn menu-button"><i class="fas fa-dollar-sign"></i> Comptabilité</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10">
            <div class="header d-flex justify-content-between align-items-center">
                <h2>Gestion des Enseignants</h2>
                <a href="#" class="btn btn-danger">Déconnexion</a>
                <img src="/assets/img/logo.png" alt="logo">
            </div>
            <div class="main-content">
                <form method="post" class="form-container">
                    <div class="row">
                        <!-- Colonne de gauche -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom">
                            </div>

                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom">
                            </div>

                            <div class="mb-3">
                                <label for="date_naissance" class="form-label">Date de Naissance</label>
                                <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                            </div>

                            <div class="mb-3">
                                <label for="niveau" class="form-label">Niveau d'Enseignements</label>
                                <select class="form-select" id="niveau" name="niveau" onchange="toggleFields()">
                                    <option value="primaire">Primaire</option>
                                    <option value="secondaire">Secondaire</option>
                                </select>
                            </div>
                        </div>

                        <!-- Colonne de droite -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Téléphone">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            </div>

                            <!-- Champ pour le choix des matières, visible uniquement si niveau = secondaire -->
                            <div id="matiere-fields">
                                <div class="mb-3">
                                    <label for="matiere1" class="form-label">Matière 1</label>
                                    <select class="form-select" id="matiere1" name="matiere1">
                                        <option>Maths</option>
                                        <option>PC</option>
                                        <option>SVT</option>
                                        <option>Anglais</option>
                                        <option>Français</option>
                                        <option>Histoire-Géographie</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="matiere2" class="form-label">Matière 2</label>
                                    <select class="form-select" id="matiere2" name="matiere2">
                                        <option>Maths</option>
                                        <option>PC</option>
                                        <option>SVT</option>
                                        <option>Anglais</option>
                                        <option>Français</option>
                                        <option>Histoire-Géographie</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Champ pour le choix de la classe, visible uniquement si niveau = primaire -->
                            <div id="classe-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="classe" class="form-label">Classe</label>
                                    <select class="form-select" id="classe" name="classe">
                                        <option>CI</option>
                                        <option>CP</option>
                                        <option>CE1</option>
                                        <option>CE2</option>
                                        <option>CM1</option>
                                        <option>CM2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                        <button type="reset" class="btn btn-secondary">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Fonction pour afficher/masquer les champs en fonction du niveau choisi
function toggleFields() {
    var niveau = document.getElementById("niveau").value;
    var matiereFields = document.getElementById("matiere-fields");
    var classeFields = document.getElementById("classe-fields");

    if (niveau === "primaire") {
        matiereFields.style.display = "none";
        classeFields.style.display = "block";
    } else {
        matiereFields.style.display = "block";
        classeFields.style.display = "none";
    }
}

// Appel initial pour afficher les bons champs lors du chargement
toggleFields();
</script>

</body>
</html>
