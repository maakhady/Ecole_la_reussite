<?php
$role = "Directeur"; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur - <?php echo $role; ?></title>
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
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2" fill="none" />
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
                    <h2>Modifier l'utilisateur</h2>
                    <div class="d-flex align-items-center">
                        <a href="/../La_reussite_academy-main/Views/ConnexionView.php" class="btn btn-danger mr-2">Déconnexion</a>
                        <div class="logo-container">
                            <img src="./assets/img/logo.png?t=<? echo time(); ?>" alt="Logo" class="logo" style="width: 100px;">
                        </div>
                    </div>
                </div>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <div class="custom-bg p-4 rounded shadow">
                    <form method="post" id="editUserForm" action="edit_user.php" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>>
                    <input type=" hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>">
                            <span class="error-message" id="error-nom"></span>
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>">
                            <span class="error-message" id="error-prenom"></span>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                            <span class="error-message" id="error-email"></span>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Rôle</label>
                            <select name="role_id" id="role" class="form-select" aria-label="Veuillez choisir une fonction">
                                <?php
                                $roles = $editUserController->getAllRoles();
                                foreach ($roles as $role) {
                                    $selected = ($role['id'] == $user['role_id']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($role['id']) . "' $selected>" . htmlspecialchars($role['nom_role']) . "</option>";
                                }
                                ?>
                            </select>
                            <span class="error-message" id="error-role"></span>
                        </div>
                        <div class="mb-3">
                            <label for="date_embauche" class="form-label">Date d'embauche</label>
                            <input type="date" class="form-control" id="date_embauche" name="date_embauche" value="<?php echo htmlspecialchars($user['date_embauche']); ?>">
                            <span class="error-message" id="error-date"></span>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Mettre à jour</button>
                            <a href="index.php" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("editUserForm").addEventListener("submit", function(event) {
            event.preventDefault();

            // Réinitialise les messages d'erreur
            document.getElementById("error-nom").textContent = "";
            document.getElementById("error-prenom").textContent = "";
            document.getElementById("error-email").textContent = "";
            document.getElementById("error-role").textContent = "";
            document.getElementById("error-date").textContent = "";

            // Récupère les valeurs des champs
            let nom = document.getElementById("nom").value.trim();
            let prenom = document.getElementById("prenom").value.trim();
            let email = document.getElementById("email").value.trim();
            let role = document.getElementById("role").value;
            let date = document.getElementById("date_embauche").value;

            // Initialise un booléen pour suivre les erreurs
            let hasError = false;

            // Validation des champs
            if (nom === "") {
                document.getElementById("error-nom").textContent = "Le nom est requis.";
                hasError = true;
            }
            if (prenom === "") {
                document.getElementById("error-prenom").textContent = "Le prénom est requis.";
                hasError = true;
            }
            if (email === "") {
                document.getElementById("error-email").textContent = "L'email est requis.";
                hasError = true;
            } else if (!validateEmail(email)) {
                document.getElementById("error-email").textContent = "Veuillez entrer un email valide.";
                hasError = true;
            }
            if (role === "") {
                document.getElementById("error-role").textContent = "Le rôle est requis.";
                hasError = true;
            }
            if (date === "") {
                document.getElementById("error-date").textContent = "La date d'embauche est requise.";
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