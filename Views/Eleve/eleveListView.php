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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css?t=<? echo time(); ?>">
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
                <button class="btn btn-success menu-button"><i class="fas fa-dollar-sign"></i> Comptabilité</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light">
                <h2>Liste des Élèves</h2>
                <div class="d-flex align-items-center">
                    <a href="/logout.php" class="btn btn-danger mr-2">Déconnexion</a>
                    <div class="logo-container">
                        <!-- <img src="../../assets/img/logo.png" alt="Logo" class="logo" style="width: 100px;"> -->
                    </div>
                </div>
            </div>
        <div class="row mb-4">
        <div class="col-4 md-4">
            <div class="stat-card">
                <h5>ELEVES</h5>
                <p class="text-primary fs-4" id="totalEleves"><?php echo number_format(count($eleves)); ?></p>
                <small>Elèves enregistrés</small>
            </div>
        </div>
        <div class="col-4 md-4">
            <div class="stat-card">
                <h5>PRIMAIRES</h5>
                <p class="text-primary fs-4" id="elevesprimaires"><?php echo ($elevesprimaires); ?></p>
                <small>Eleves Primaires</small>
            </div>
        </div>
        <div class="col-4 md-4">
            <div class="stat-card">
                <h5>SECONDAIRES</h5>
                <p class="text-primary fs-4" id="elevesprimaires"><?php echo ($elevessecondaires); ?></p>
                <small>Eleves Secondaires</small>
            </div>
        </div>
    </div>

            <div class="d-flex justify-content-between row mb-4">
                <div class="col-8">
                <a href="index.php?action=inscriptionEleve" class="btn btn-success">AJOUT D'UN ÉLÈVE</a>
                </div>
                <div class="col-4">
                <input type="text" class="form-control w-30 " placeholder="Rechercher" id="textRechercher">
                </div>
            </div>

            <!-- Section liste des élèves -->
            <div class="bg-white p-4 rounded shadow">
                <h5 class="text-center mb-4">Liste des Élèves</h5>
                <div class="table-responsive">
                <?php if (is_array($eleves) && count($eleves) > 0) : ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col-3">Matricule</th>
                                    <th scope="col-3">Nom</th>
                                    <th scope="col-3">Prénom</th>
                                    <th scope="col-3">Date de Naissance</th>
                                    <th scope="col-3">Nom du Tuteur</th>
                                    <th scope="col-3">Email du Tuteur</th>
                                    <th scope="col-3">Departement</th>
                                    <th scope="col-3">Classe</th>
                                    <th scope="col-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tableauEleves">
                                <?php foreach ($eleves as $eleve): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($eleve['matricule']); ?></td>
                                        <td><?= htmlspecialchars($eleve['nom']); ?></td>
                                        <td><?= htmlspecialchars($eleve['prenom']); ?></td>
                                        <td><?= htmlspecialchars($eleve['date_naissance']); ?></td>
                                        <td><?= htmlspecialchars($eleve['nom_tuteur']); ?></td>
                                        <td><?= htmlspecialchars($eleve['email_tuteur']); ?></td>
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
<script>
    $(document).ready(function() {
    $("#textRechercher").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableauEleves tr").filter(function() {
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


