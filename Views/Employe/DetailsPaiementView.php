<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Paiement</title>
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
        <div class="col-md-10 offset-md-2 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light">
                <h2>Détails du Paiement</h2>
                <div class="d-flex align-items-center">
                    <a href="/La_reussite_academy-main/index.php?action=afficherPersonnelAPayer" class="btn btn-secondary mr-2">Retour à la liste</a>
                    <a href="/La_reussite_academy-main/logout.php" class="btn btn-danger">Déconnexion</a>
                </div>
            </div>

            <?php if (isset($employe) && is_array($employe)): ?>
                <div class="bg-white p-4 rounded shadow">
                    <h3><?php echo htmlspecialchars($employe['nom'] . ' ' . $employe['prenom']); ?></h3>
                    <p><strong>Rôle:</strong> <?php echo htmlspecialchars($employe['nom_role']); ?></p>
                    <p><strong>Salaire Brut:</strong> <?php echo htmlspecialchars($employe['salaire_brut']); ?></p>

                    <form action="/La_reussite_academy-main/index.php?action=effectuerPaiement" method="POST" class="mt-4">
                        <input type="hidden" name="id" value="<?php echo $employe['id']; ?>">
                        
                        <div class="mb-3">
                            <label for="moisPaiement" class="form-label">Mois:</label>
                            <input type="month" id="moisPaiement" name="mois" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="modePaiement" class="form-label">Mode de paiement:</label>
                            <select id="modePaiement" name="mode_paiement" class="form-select" required>
                                <option value="waves">Waves</option>
                                <option value="especes">Espèces</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="montantPaiement" class="form-label">Montant à payer:</label>
                            <input type="number" id="montantPaiement" name="montant" class="form-control" value="<?php echo $employe['salaire_brut']; ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Effectuer le paiement</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">Aucune information disponible pour cet employé.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>