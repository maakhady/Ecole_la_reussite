<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Élève</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/css/style1.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark">
                        <svg class="me-2" width="52" height="40">
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2" fill="none"/>
                            <text x="15" y="25" fill="black" font-size="12">D</text>
                        </svg> 
                        <span class="fs-4" style="font-weight: bold; font-size: 1.5rem;">Directeur</span> 
                    </div>
                    <br> <br>
                    <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-tachometer-alt"></i> Tableau de Bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user-graduate"></i> Utilisateurs
                        </a>
                    </li>
                    <li class="">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-chalkboard-teacher"></i> Élèves
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chalkboard-teacher"></i> Enseignants
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-users"></i> Employés
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-book"></i> Cours
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-clipboard-list"></i> Présences
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-clipboard"></i> Notes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar-alt"></i> Emplois du temps
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-dollar-sign"></i> Comptabilité
                        </a>
                    </li>
                </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ml-sm-auto px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Ajouter un Élève</h1>
                    <div class="d-flex align-items-center">
                        <a href="Views/ConnexionView.php" class="btn btn-danger mr-2">Déconnexion</a>
                        <img src="./assets/img/logo.png" alt="Logo" style="width: 90px;">
                    </div>
                </div>

                <!-- Formulaire d'ajout d'élève -->
                <div class="bg-light p-4 rounded border border-primary">
                    <h5 class="text-center mb-4">Formulaire d'Ajout d'Élève</h5>
                    <form action="eleves.php?action=createEleve" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="matricule">Matricule</label>
                                <input type="text" class="form-control" id="matricule" name="matricule" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date_naissance">Date de Naissance</label>
                                <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                            </div>
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
                        <div class="form-group">
                            <label for="nom_tuteur">Nom du Tuteur</label>
                            <input type="text" class="form-control" id="nom_tuteur" name="nom_tuteur" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tel_tuteur">Téléphone du Tuteur</label>
                                <input type="tel" class="form-control" id="tel_tuteur" name="tel_tuteur" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email_tuteur">Email du Tuteur</label>
                                <input type="email" class="form-control" id="email_tuteur" name="email_tuteur" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="departement">Département</label>
                                <select class="form-control" id="departement" name="departement" required>
                                    <option value="" disabled selected>Sélectionnez un département</option>
                                    <option value="Primaire">Primaire</option>
                                    <option value="Secondaire">Secondaire</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="classe">Classe</label>
                                <select class="form-control" id="classe" name="classe" required>
                                    <option value="" disabled selected>Choisir une classe</option>
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
            </main>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
