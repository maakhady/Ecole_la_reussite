<?php
require_once '../../Config/database.php';
require_once '../../Controllers/PaiementPersonnelController.php';

try {
    $pdo = Database::getInstance();
    $controller = new PaiementPersonnelController($pdo);

    // Traitement des actions
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['effectuer_paiement'])) {
        $result = $controller->effectuerPaiement();
        if ($result['success']) {
            $message = "Paiement effectué avec succès";
        } else {
            $error = $result['message'];
        }
    }

    // Récupération des données pour l'affichage
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $paiementsData = $controller->getPaiementsData($page);
    $paiements = $paiementsData['paiements'];
    $totalPages = $paiementsData['totalPages'];

    // Récupération des messages
    $message = $message ?? $_GET['message'] ?? null;
    $error = $error ?? $_GET['error'] ?? null;
} catch (Exception $e) {
    $error = "Une erreur est survenue : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement du Personnel</title>
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
                        <text x="15" y="25" fill="black" font-size="12">C</text>
                    </svg>
                    <h4><span class="fs-4" style="font-weight: bold; font-size: 1.5rem;">Comptable</span></h4>
                </div>     
            </div><br>
            <div class="d-grid gap-4">
                <button class="btn btn-success menu-button"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</button>
                <button class="btn btn-success menu-button"><i class="fas fa-user-graduate"></i> Élèves</button>
                <button class="btn btn-success menu-button active"><i class="fas fa-users"></i> Paiements Personnel</button>
                <button class="btn btn-success menu-button"><i class="fas fa-clipboard-list"></i> Présences</button>
                <button class="btn btn-success menu-button"><i class="fas fa-dollar-sign"></i> Salaires</button>
                <button class="btn btn-success menu-button"><i class="fas fa-history"></i> Historique</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light">
                <h2>Paiement du Personnel</h2>
                <div class="d-flex align-items-center">
                    <a href="/La_reussite_academy-main/logout.php" class="btn btn-danger mr-2">Déconnexion</a>
                    <div class="logo-container">
                        <img src="/La_reussite_academy-main/assets/img/logo.png" alt="Logo" class="logo">
                    </div>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="bg-white p-4 rounded shadow">
                <h5 class="text-center mb-4">Liste des Paiements du Personnel</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Matricule</th>
                                <th>Rôle</th>
                                <th>Salaire Brut</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Mode de Paiement</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableauPaiements">
                                <?php if (!empty($paiements)): ?>
                                    <?php foreach ($paiements as $paiement): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($paiement['nom'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($paiement['prenom'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($paiement['matricule'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($paiement['nom_role'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($paiement['salaire_brut'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($paiement['montant'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($paiement['statut_paiement'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($paiement['mode_paiement'] ?? ''); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#paiementModal<?php echo $paiement['id']; ?>">
                                                Effectuer paiement
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Modal pour effectuer le paiement -->
                                    <div class="modal fade" id="paiementModal<?php echo $paiement['id']; ?>" tabindex="-1" aria-labelledby="paiementModalLabel<?php echo $paiement['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="paiementModalLabel<?php echo $paiement['id']; ?>">Effectuer un paiement pour <?php echo htmlspecialchars($paiement['nom'] . ' ' . $paiement['prenom']); ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($paiement['id']); ?>">
                                                        <input type="hidden" name="salaire_personnel_id" value="<?php echo htmlspecialchars($paiement['id']); ?>">
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <p><strong>Nom:</strong> <?php echo htmlspecialchars($paiement['nom']); ?></p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p><strong>Prénom:</strong> <?php echo htmlspecialchars($paiement['prenom']); ?></p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p><strong>Matricule:</strong> <?php echo htmlspecialchars($paiement['matricule']); ?></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <input type="hidden" name="role" value="<?php echo htmlspecialchars($paiement['nom_role']); ?>">
                                                                <p><strong>Rôle:</strong> <?php echo htmlspecialchars($paiement['nom_role']); ?></p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p><strong>Salaire Brut:</strong> <?php echo htmlspecialchars($paiement['salaire_brut']); ?></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <p><strong>Statut actuel:</strong> <?php echo htmlspecialchars($paiement['statut_paiement']); ?></p>
                                                            </div>
                                                            <!-- <div class="col-md-6">
                                                                <p><strong>Mode de paiement actuel:</strong> <?php echo htmlspecialchars($paiement['mode_paiement'] ?? '-'); ?></p>
                                                            </div> -->
                                                        </div>

                                                        <hr>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="mois" class="form-label">Mois de paiement</label>
                                                               
                                                                <select class="form-select" id="mois" name="mois" required>
                                                                    <option value="">Sélectionner un mois</option>
                                                                <option value="Janvier">Janvier</option>
                                                                <option value="Fevrier">Février</option>
                                                                <option value="Mars">Mars</option>
                                                                <option value="Avril">Avril</option>
                                                                <option value="Mai">Mai</option>
                                                                <option value="Juin">Juin</option>
                                                                <option value="Juillet">Juillet</option>
                                                                <option value="Aout">Août</option>
                                                                <option value="Septembre">Septembre</option>
                                                                <option value="Octobre">Octobre</option>
                                                                <option value="Novembre">Novembre</option>
                                                                <option value="Decembre">Décembre</option>
                                                            </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="mode_paiement" class="form-label">Mode de paiement</label>
                                                                <select class="form-select" id="mode_paiement" name="mode_paiement" required>
                                                                <option value="">Sélectionner un mode de paiement</option>
                                                                <option value="Wave" <?php echo ($paiement['mode_paiement'] == 'Wave') ? 'selected' : ''; ?>>Wave</option>
                                                                <option value="Especes" <?php echo ($paiement['mode_paiement'] == 'Especes') ? 'selected' : ''; ?>>Espèces</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="montant" class="form-label">Montant à payer</label>
                                                            <input type="number" step="0.01" class="form-control" id="montant" name="montant" value="<?php echo htmlspecialchars($paiement['salaire_brut']); ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" name="effectuer_paiement" class="btn btn-success">Effectuer le paiement</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="9">Aucune donnée disponible</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Précédent">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Suivant">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[id^="paiementForm"]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const modeSelect = this.querySelector('select[name="mode_paiement"]');
            const modeSelected = modeSelect.value;
            console.log('Mode de paiement sélectionné:', modeSelected);
            console.log('Longueur de la valeur:', modeSelected.length);
            console.log('Code ASCII du premier caractère:', modeSelected.charCodeAt(0));

            if (!modeSelected) {
                e.preventDefault();
                alert('Veuillez sélectionner un mode de paiement.');
            }
        });
    });
});

function confirmerSuppression(paiementId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?')) {
        document.getElementById('formSuppression' + paiementId).submit();
    }
}

</script>
</body>
</html>