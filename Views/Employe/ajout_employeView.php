<?php

session_start(); // Démarrer la session si ce n'est pas déjà fait
$oldData = isset($_SESSION['old_data']) ? $_SESSION['old_data'] : [];

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
                        <input type="text" name="nom" class="form-control" id="name" autocomplete="Nom-de-famille" value="<?php echo isset($oldData['nom']) ? htmlspecialchars($oldData['nom']) : ''; ?>">
                        <span class="error-message" id="error-name"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" id="prenom" autocomplete="Prenom" value="<?php echo isset($oldData['prenom']) ? htmlspecialchars($oldData['prenom']) : ''; ?>">
                        <span class="error-message" id="error-prenom"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date de naissance</label>
                        <input type="date" name="date_naissance" class="form-control" id="date" value="<?php echo isset($oldData['date_naissance']) ? htmlspecialchars($oldData['date_naissance']) : ''; ?>">
                        <span class="error-message" id="error-date"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" autocomplete="Adresse-mail" value="<?php echo isset($oldData['email']) ? htmlspecialchars($oldData['email']) : ''; ?>">
                        <span class="error-message" id="error-email"></span>
                        <span class= "error-message" id="mail-doublon">
                        <?php
                            if (isset($_SESSION['exist_mail']) && $_SESSION['exist_mail'] === true) {
                                echo 'Cet email existe déjà.';
                                unset($_SESSION['exist_mail']);
                            }
                        ?>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="tel" name="telephone" class="form-control" id="phone" autocomplete="tel" value="<?php echo isset($oldData['telephone']) ? htmlspecialchars($oldData['telephone']) : ''; ?>">
                        <span class="error-message" id="error-phone"></span>
                        <span class= "error-message" id="tel-doublon">
                        <?php
                            if (isset($_SESSION['exist_telephone']) && $_SESSION['exist_telephone'] === true) {
                                echo 'Ce numéro de téléphone existe déjà.';
                                unset($_SESSION['exist_telephone']);
                            }
                        ?>
                    </span>
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
                        <input type="password" name="mot_de_passe" class="form-control" id="password" autocomplete="Mot-de-passe" value="<?php echo isset($oldData['mot_de_passe']) ? htmlspecialchars($oldData['mot_de_passe']) : ''; ?>">
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
                                    <select class="form-select" id="matiere1" name="matiere1" aria-label="Choisissez une matière">
                                    <option selected disabled>Choisissez une matière</option>
                                        <option value="Maths">Maths</option>
                                        <option value="PC">PC</option>
                                        <option value="SVT">SVT</option>
                                        <option value="Anglais">Anglais</option>
                                        <option value="Français">Français</option>
                                        <option value="HG">Histoire-Géographie</option>
                                    </select>
                                    <span class="error-message" id="error-matiere1"></span>
                                </div>

                                <div class="mb-3">
                                    <label for="matiere2" class="form-label">Matière 2</label>
                                    <select class="form-select" id="matiere2" name="matiere2">
                                    <option selected disabled>La seconde matière est facultatif</option>
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
                                    <option selected disabled>Choisissez une classe</option>
                                        <option value="CI">CI</option>
                                        <option value="CP">CP</option>
                                        <option value="CE1">CE1</option>
                                        <option value="CE2">CE2</option>
                                        <option value="CM1">CM1</option>
                                        <option value="CM2">CM2</option>
                                    </select>
                                    <span class="error-message" id="error-classe"></span>
                                </div>
                            </div>
                    </div>
                    <div class="col-12 text-center">
                        <button class="btn btn-success" type="submit">Enregistrer</button>
                        <a href="/../La_reussite_academy-main/index.php" class="btn btn-danger mr-2">Retour</a>
                    </div>
                </form>
                <?php
                // Après avoir affiché le formulaire, nettoyer les anciennes données de la session si vous ne voulez pas qu'elles persistent
                    unset($_SESSION['old_data']);
                ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/javasc/signupEmploye.js" ></script>
</body>
</html>