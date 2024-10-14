<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$role= "Comptable";


           
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frais d'inscription des élèves - <?php echo $role; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <h4><span class="fs-4" style="font-weight: bold; font-size: 1.5rem;"><?php echo $role; ?></span></h4>
                </div>     
            </div><br>
            <div class="d-grid gap-4">
                <button class="btn btn-success menu-button"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</button>
                <button class="btn link btn-success menu-button"><i class="fas fa-chalkboard-teacher"></i> Élèves</button>
                <button class="btn btn-success menu-button"><i class="fas fa-user"></i>Enseignats</button>
                <button class="btn link btn-success menu-button"><i class="fas fa-user"></i> Employer</button>          
                <button class="btn btn-success menu-button"><i class="fas fa-clipboard-list"></i> Présences</button>
                <button class="btn btn-success menu-button"><i class="fas fa-dollar-sign"></i> Salaire</button>
                <button class="btn btn-success menu-button"><i class="fas fa-calendar-alt"></i> Historique</button>
            
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light">
                <h2>Frais d'inscription d'un Élève</h2>
                <div class="d-flex align-items-center">
                    <a href="/../La_reussite_academy-main/Views/ConnexionView.php" class="btn btn-danger mr-2">Déconnexion</a>
                    <div class="logo-container">
                        <img src="./assets/img/logo.png?t=<? echo time(); ?>" alt="Logo" class="logo" style="width: 100px;">
                    </div>
                </div>
            </div>




           
</head>

<body>
    <div class="container mt-5">
        
        <div class="row justify-content-center">
            <div class="col-md-8 form-container">
                <h3 class="text-center text-success mb-4"> Frais d'inscription des Élèves</h3>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" >
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?> ">
 
                <div class="row mb-4">
                    <div class=" col-md-6">
                    <label for="nom" class="form-label">Nom</label>
                     <input type="text" class="form-control" id="nom" name="nom"  value="<?php  $eleve['nom'] ?>" readonly>
                        
                    </div>

                    <div class=" col-md-6">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom"  value="<?php echo $prenom; ?>" readonly>
                        </div>
                </div>
                <div class="row mb-4">
                    <div class="mb-3 col-md-6">
                    <label for="matricule" class="form-label">Matricule</label>
                    <input type="text" class="form-control" id="matricule" name="matricule"  value="<?php $eleve['matricule'] ?>" readonly>
                        </div>
                <div class="mb-3 col-md-6">
                <label for="classe" class="form-label">Classe</label>
                <input type="text" class="form-control" id="classe" name="classe" value="<?php echo $classe; ?>"readonly>
                        </div>
                <div class="row mb-4">
                    <div class="mb-3 col-md-6">
                        <label for="Mode de payement" class="form-label">Mode de payement</label>
                        
                        <select class="form-select" id="mode_paiement" name="mode_paiement" >
                            <option value="">Sélectionnez un Mode de payement</option>
                            <option value="Espèces">Espèces</option>
                            <option value="Carte">Carte</option>
                            <option value="Chèque">Chèque</option>
                        </select>
                    </div>
                   
                    <div class="col-md-6">
                    <label for="montant<" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="montant" name="montant" required >
                        
                </div>
                </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="submit" class="btn  btn-lg btn-green d-grid gap-2 col-3 mx-auto">Enregistrer</button>
                        <a href="fraisInscription_eleve_Views.php"><button type="button" class="btn btn-lg btn-warning ">Retour</button></a>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
        
            </div>
    </div>
    </div>
</div>


</body>
</html>