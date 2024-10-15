<?php
// Assurez-vous que $eleves est défini et est un tableau
if (!isset($eleves) || !is_array($eleves)) {
    $eleves = [];
}
$role = "Directeur";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Élèves - <?php echo $role; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
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
                <a href="/../La_reussite_academy-main/index.php"><button class="btn btn-success menu-button"><i class="fas fa-user-graduate"></i> Utilisateurs</button></a>            
                <button class="btn link btn-success menu-button"><i class="fas fa-chalkboard-teacher"></i> Élèves</button>
                <button class="btn btn-success menu-button"><i class="fas fa-book"></i> Cours</button>
                <button class="btn btn-success menu-button"><i class="fas fa-clipboard-list"></i> Présences</button>
                <button class="btn btn-success menu-button"><i class="fas fa-clipboard"></i> Notes</button>
                <button class="btn btn-success menu-button"><i class="fas fa-calendar-alt"></i> Emplois du temps</button>
                <a href="/../La_reussite_academy-main/Views/comptable/espace_comptView.php"><button class="btn btn-success menu-button"><i class="fas fa-dollar-sign"></i> Comptabilité</button></a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light">
                <h2>Liste des Élèves</h2>
                <div class="d-flex align-items-center">
                    <a href="/../La_reussite_academy-main/Views/ConnexionView.php" class="btn btn-danger mr-2">Déconnexion</a>
                    <div class="logo-container">
                        <img src="../img/logo.png" alt="Logo" class="logo" style="width: 100px;">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-4">
                <a href="index.php?action=inscriptionEleve" class="btn btn-success">AJOUT D'UN ÉLÈVE</a>
                <input type="text" class="form-control w-25" placeholder="Rechercher">
            </div>

            <!-- Section liste des élèves -->
            <div class="bg-white p-4 rounded shadow">
                <h5 class="text-center mb-4">Liste des Élèves</h5>
                <div class="table-responsive">
                    <?php if (count($eleves) > 0) : ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Matricule</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Date de Naissance</th>
                                    <th scope="col">Nom du Tuteur</th>
                                    <th scope="col">Departement</th>
                                    <th scope="col">Classe</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($eleves as $eleve): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($eleve['matricule']); ?></td>
                                        <td><?= htmlspecialchars($eleve['nom']); ?></td>
                                        <td><?= htmlspecialchars($eleve['prenom']); ?></td>
                                        <td><?= htmlspecialchars($eleve['date_naissance']); ?></td>
                                        <td><?= htmlspecialchars($eleve['nom_tuteur']); ?></td>
                                        <td><?= htmlspecialchars($eleve['departement']); ?></td>
                                        <td><?= htmlspecialchars($eleve['classe']); ?></td>
                                        <td>
                                            <a href="edit_eleve.php?id=<?= urlencode($eleve['id']); ?>" class="btn btn-sm btn-primary">Modifier</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p><h2>Aucun élève enregistré.</h2></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>