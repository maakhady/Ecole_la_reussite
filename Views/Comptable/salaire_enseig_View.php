<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salaires des Enseignants</title>
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
                    <h4><span class="fs-4" style="font-weight: bold; font-size: 1.5rem;">DIRECTEUR</span></h4>
                </div>     
            </div><br>
            <div class="d-grid gap-4">
                    <button class="btn btn-success menu-button"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</button>
                    <a href="/../La_reussite_academy-main/index.php"><button class="btn btn-success menu-button"><i class="fas fa-user-graduate"></i> Utilisateurs</button></a>            
                    <a href="/../La_reussite_academy-main/eleves.php"><button class="btn btn-success menu-button"><i class="fas fa-chalkboard-teacher"></i> Élèves</button></a>
                    <!-- <button class="btn btn-success menu-button"><i class="fas fa-chalkboard-teacher"></i> Enseignants</button> -->
                    <!-- <button class="btn btn-success menu-button"><i class="fas fa-users"></i> Employés</button> -->
                    <button class="btn btn-success menu-button"><i class="fas fa-book"></i> Cours</button>
                    <button class="btn btn-success menu-button"><i class="fas fa-clipboard-list"></i> Présences</button>
                    <button class="btn btn-success menu-button"><i class="fas fa-clipboard"></i> Notes</button>
                    <button class="btn btn-success menu-button"><i class="fas fa-calendar-alt"></i> Emplois du temps</button>
                    <a href="/La_reussite_academy-main/Views/Employe/Comptabilté.php"><button class="btn link btn-success menu-button"><i class="fas fa-dollar-sign"></i> Comptabilité</button></a>
                </div>
            </div>
        <!-- Main Content -->
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light">
                <h2>Salaires des Enseignants</h2>
                <div class="d-flex align-items-center">
                    <a href="/La_reussite_academy-main/logout.php" class="btn btn-danger mr-2">Déconnexion</a>
                    <div class="logo-container">
                        <img src="/La_reussite_academy-main/assets/img/logo.png" alt="Logo" class="logo">
                    </div>
                </div>
            </div>
            
            <div class="btn-group w-100 mb-4 gap-4 d-flex justify-content-between" role="group">
<a href="/La_reussite_academy-main/index.php?action=listSalairesProfesseurs"><button type="button" class="btn btn-success flex-grow-1">EMPLOYES PROFESSEURS</button></a>
<a href="/La_reussite_academy-main/index.php?action=listSalairesPersonnels"><button type="button" class="btn btn-success flex-grow-1">EMPLOYES PERSONNELS</button></a>
                  <a href="#"><button type="button" class="btn link btn-success flex-grow-1">EMPLOYES ENSEIGNANTS</button></a>  
            </div>

            <div class="bg-white p-4 rounded shadow">
                <h5 class="text-center mb-4">Liste des Salaires des Enseignants par Classe</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="col-4">Classe</th>
                                <th class="col-4">Salaire Brut</th>
                                <th class="col-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($salaires) && is_array($salaires) && !empty($salaires)): ?>
                            <?php foreach ($salaires as $salaire): ?>
                                <tr>
                                    <td><?= htmlspecialchars($salaire['id_classe']) ?></td>
                                    <td><?= number_format($salaire['salaire_brut'], 2, ',', ' ') ?> FCFA</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm modifier-salaire" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modifierSalaireModal" 
                                            data-id="<?= $salaire['id'] ?>" 
                                            data-salaire="<?= $salaire['salaire_brut'] ?>">
                                            Modifier
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">Aucun salaire enregistré.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
 <!-- Modal -->
 <div class="modal fade" id="modifierSalaireModal" tabindex="-1" aria-labelledby="modifierSalaireModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifierSalaireModalLabel">Modifier le salaire brut</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="formModifierSalaire">
                    <input type="hidden" id="enseignantId" name="id">
                    <div class="mb-3">
                        <label for="nouveauSalaire" class="form-label">Nouveau salaire brut</label>
                        <input type="number" class="form-control" id="nouveauSalaire" name="salaire_brut" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="btnEnregistrerSalaire">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
    var modifierSalaireModal = document.getElementById('modifierSalaireModal');
    var formModifierSalaire = document.getElementById('formModifierSalaire');
    var btnEnregistrerSalaire = document.getElementById('btnEnregistrerSalaire');

    // Remplir le modal avant qu'il ne soit affiché
    modifierSalaireModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var salaire = button.getAttribute('data-salaire');
        
        formModifierSalaire.querySelector('#enseignantId').value = id;
        formModifierSalaire.querySelector('#nouveauSalaire').value = salaire;
    });

    // Gérer la soumission du formulaire
    btnEnregistrerSalaire.addEventListener('click', function() {
        var formData = new FormData(formModifierSalaire);

        fetch('index.php?action=mettreAJourSalaireEnseignant', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Salaire mis à jour avec succès');
                location.reload();
            } else {
                alert('Erreur lors de la mise à jour du salaire: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour du salaire');
        })
        .finally(() => {
            var modalInstance = bootstrap.Modal.getInstance(modifierSalaireModal);
            modalInstance.hide();
        });
    });
});
        </script>
</body>
</html>