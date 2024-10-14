
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







});