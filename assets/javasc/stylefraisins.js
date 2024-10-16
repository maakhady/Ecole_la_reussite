
  //fonction global java
  document.addEventListener('DOMContentLoaded', function() {
    var inscriptionModal = document.getElementById('inscriptionModal');
    var inscriptionForm = document.getElementById('inscriptionForm');

    // When the modal is shown, fill in the data
    inscriptionModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget; // Button that triggered the modal
      var id = button.getAttribute('data-id');
      var nom = button.getAttribute('data-nom');
      var prenom = button.getAttribute('data-prenom');
      var matricule = button.getAttribute('data-matricule');
      var classe = button.getAttribute('data-classe');
     

      // Update the modal's form with the student data
      document.getElementById('id').value = id;
      document.getElementById('nom').value = nom;
      document.getElementById('prenom').value = prenom;
      document.getElementById('matricule').value = matricule;
      document.getElementById('classe').value = classe;
      
     
//

    // Modal de confirmation de paiement
    var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    var confirmationMessage = document.getElementById('confirmationMessage');
    var confirmPaymentButton = document.getElementById('confirmPaymentButton');

    // Lorsque le formulaire est soumis, montrer la confirmation
    inscriptionForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche la soumission immédiate du formulaire

        var nom = document.getElementById('nom').value;
        var montant = document.getElementById('montant').value;
        var modePaiement = document.getElementById('mode_paiement').value;

        // Vérifier que le montant et le mode de paiement sont remplis avant de montrer le modal
        if (montant && modePaiement) {
            confirmationMessage.textContent = "Confirmez-vous le paiement de " + montant + " CFA pour l'élève " + nom + "  " + prenom  + " par " + modePaiement + " ?";
            confirmationModal.show();

            // Si l'utilisateur confirme, soumettre le formulaire
            confirmPaymentButton.onclick = function() {
                inscriptionForm.submit();
            };
        } else {
            alert("Veuillez remplir tous les champs obligatoires.");
        }
    });
});

paginateTable();
});



 

function filterTable() {
    // Récupérer la valeur de l'input de recherche
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const table = document.getElementById('studentsTable');
    const rows = table.getElementsByTagName('tr'); // Récupérer toutes les lignes du tableau

    // Parcourir toutes les lignes du tableau
    for (let i = 1; i < rows.length; i++) { // Commencer à 1 pour ignorer l'en-tête
        const cells = rows[i].getElementsByTagName('td'); // Récupérer toutes les cellules d'une ligne
        let rowContainsSearchTerm = false;

        // Vérifier si l'une des cellules contient le texte de recherche
        for (let j = 0; j < cells.length; j++) {
            if (cells[j].textContent.toLowerCase().includes(searchInput)) {
                rowContainsSearchTerm = true;
                break; // Pas besoin de vérifier plus de cellules si on a déjà trouvé une correspondance
            }
        }

        // Afficher ou masquer la ligne selon qu'elle contient le texte recherché
        rows[i].style.display = rowContainsSearchTerm ? '' : 'none';
    }
}

 

 // Définir le nombre d'élèves à afficher par page
 const rowsPerPage = 10;
let currentPage = 1;

function paginateTable() {
    const table = document.getElementById('studentsTable');
    const rows = table.getElementsByTagName('tr');
    const totalRows = rows.length - 1; // Exclure l'en-tête
    const totalPages = Math.ceil(totalRows / rowsPerPage);

    // Afficher uniquement les lignes pour la page actuelle
    for (let i = 1; i <= totalRows; i++) {
        const rowIndex = i - 1; // Corriger l'index car 'rows' inclut l'en-tête
        if (i > (currentPage - 1) * rowsPerPage && i <= currentPage * rowsPerPage) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }

    // Mettre à jour les boutons de pagination
    const paginationElement = document.getElementById('pagination');
    paginationElement.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const pageButton = document.createElement('button');
        pageButton.classList.add('btn', 'btn-secondary', 'mx-1');
        pageButton.textContent = i;
        pageButton.onclick = function() {
            currentPage = i;
            paginateTable();
        };
        if (i === currentPage) {
            pageButton.classList.add('active');
        }
        paginationElement.appendChild(pageButton);
    }
}

