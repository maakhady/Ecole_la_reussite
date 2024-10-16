<?php

// Ici, vous pouvez ajouter toute logique PHP nécessaire, comme la récupération des données depuis une base de données
$role = "Directeur";

session_start();


// Assurez-vous que $users est défini et est un tableau
if (!isset($users) || !is_array($users)) {
    $users = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - <?php echo $role; ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/La_reussite_academy-main/assets/css/style.css"> 
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
                        <h4><span class="fs-4" style="font-weight: bold; font-size: 1.5rem;"></span><?php echo $role; ?></span> </h4>
                    </div>     
                </div><br>
                <div class="d-grid gap-4">
                    <button class="btn btn-success menu-button"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</button>
                    <a href="/../La_reussite_academy-main/index.php"><button class="btn link btn-success menu-button"><i class="fas fa-user-graduate"></i> Utilisateurs</button></a>            
                    <a href="/../La_reussite_academy-main/eleves.php"><button class="btn btn-success menu-button"><i class="fas fa-chalkboard-teacher"></i> Élèves</button></a>
                    <!-- <button class="btn btn-success menu-button"><i class="fas fa-chalkboard-teacher"></i> Enseignants</button> -->
                    <!-- <button class="btn btn-success menu-button"><i class="fas fa-users"></i> Employés</button> -->
                    <button class="btn btn-success menu-button"><i class="fas fa-book"></i> Cours</button>
                    <button class="btn btn-success menu-button"><i class="fas fa-clipboard-list"></i> Présences</button>
                    <button class="btn btn-success menu-button"><i class="fas fa-clipboard"></i> Notes</button>
                    <button class="btn btn-success menu-button"><i class="fas fa-calendar-alt"></i> Emplois du temps</button>
                    <a href="/La_reussite_academy-main/Views/Employe/Comptabilté.php"><button class="btn btn-success menu-button"><i class="fas fa-dollar-sign"></i> Comptabilité</button></a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light">
                    <h2>Tableau de Bord</h2>
                    <div class="d-flex align-items-center">
                        <a href="/La_reussite_academy-main/logout.php" class="btn btn-danger mr-2">Déconnexion</a>
                        <div class="logo-container">
                            <img src="/La_reussite_academy-main/assets/img/logo.png" alt="Logo" class="logo" style="width: 100px;">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <h5>PROFESSEURS</h5>
                            <p class="text-primary fs-4"><?php echo number_format($prof); ?></p>
                            <small>Professeurs enregistrés</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <h5>ENSEIGNANTS</h5>
                            <p class="text-primary fs-4"><?php echo number_format($enseignants); ?></p>
                            <small>Enseignants enregistrés</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <h5>AUTRES EMPLOYES</h5>
                            <p class="text-primary fs-4"><?php echo number_format($employes); ?></p>
                            <small>Employés enregistrés</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <a href="/../La_reussite_academy-main/Views/Employe/ajout_employeView.php" class="btn btn-success">AJOUT D'UN UTILISATEUR</a>
                    <input type="text" class="form-control w-25" placeholder="Rechercher" id="textRechercher">
                </div> 

                <!-- Section liste des utilisateurs -->
                <div class="bg-white p-4 rounded shadow">
                    <h5 class="text-center mb-4">Liste des Utilisateurs</h5>
                    <div class="table-responsive">
                        <?php if (count($users) > 0) : ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Matricule</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prénom</th>
                                        <th scope="col">Rôle</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Date d'embauche</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="tableauUsers">
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($user['matricule']); ?></td>
                                            <td><?= htmlspecialchars($user['nom']); ?></td>
                                            <td><?= htmlspecialchars($user['prenom']); ?></td>
                                            <td><?= htmlspecialchars($user['role']); ?></td>
                                            <td><?= htmlspecialchars($user['email']); ?></td>
                                            <td><?= htmlspecialchars($user['date_embauche']); ?></td>
                                            <td class="actions">
                                                <a href="edit_user.php?id=<?= urlencode($user['id']); ?>" class="btn btn-sm btn-primary">Modifier</a>
                                                <!-- <a href="/Views/Eleve/archive_userView.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger">Archiver</a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?action=listUsers&page=<?php echo $page - 1; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?action=listUsers&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?action=listUsers&page=<?php echo $page + 1; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php else: ?>
                            <p><h2>Aucun utilisateur enregistré. </h2></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
$(document).ready(function() {
     $("#textRechercher").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableauUsers tr").filter(function() {
            var matricule = $(this).find("td:eq(0)").text().toLowerCase();
            var nom = $(this).find("td:eq(1)").text().toLowerCase();
            var prenom = $(this).find("td:eq(2)").text().toLowerCase();
            var matchFound = matricule.indexOf(value) > -1 || nom.indexOf(value) > -1 || prenom.indexOf(value) > -1;
            $(this).toggle(matchFound);
             });
        });
    });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>