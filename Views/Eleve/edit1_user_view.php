<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Modifier l'utilisateur</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

            <!-- <div class="mb-3">
                <label for="matricule" class="form-label">Matricule</label>
                <input type="text" class="form-control" id="matricule" name="matricule" value="<?php echo htmlspecialchars($user['matricule']); ?>">
                
            </div> -->

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
                <label for="role_id" class="form-label">Role </label>
                <input type="number" class="form-control" id="role_id" name="role_id" value="<?php echo htmlspecialchars($user['role_id']); ?>">
            </div>

            <div class="mb-3">
                <label for="date_embauche" class="form-label">Date d'embauche</label>
                <input type="date" class="form-control" id="date_embauche" name="date_embauche" value="<?php echo htmlspecialchars($user['date_embauche']); ?>">
            </div>

            
                <button type="submit" class="btn btn-green">Mettre à jour</button>
                <button type="submit" class="btn btn-secondary"><a href="index.php">Annuler</a></button>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
