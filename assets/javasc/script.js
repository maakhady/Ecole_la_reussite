document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.querySelector("#togglePassword");
    const passwordField = document.querySelector("#mot_passe");

    togglePassword.addEventListener("click", function () {
        // Bascule le type de l'input entre 'password' et 'text'
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);
        
        // Change l'icône
        this.querySelector('i').classList.toggle("fa-eye");
        this.querySelector('i').classList.toggle("fa-eye-slash");
    });
});

//---------------------------L OEIL QUI PERMET DE VOIR LE MOT DE PASSE-----------------
function togglePassword() {
    const passwordInput = document.getElementById('mot_passe');
    const toggleIcon = document.getElementById('togglePasswordIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text'; 
        toggleIcon.classList.remove('fa-eye'); 
        toggleIcon.classList.add('fa-eye-slash'); 
    } else {
        passwordInput.type = 'password'; 
        toggleIcon.classList.remove('fa-eye-slash'); 
        toggleIcon.classList.add('fa-eye'); 
    }
}
//----------------------------VALIDATION DU FORMULAIRE ------------------------
function validateForm(event) {
    // Empêcher l'envoi du formulaire pour valider les champs
    event.preventDefault();

    // Réinitialiser les messages d'erreur
    document.getElementById("emailError").textContent = "";
    document.getElementById("passwordError").textContent = "";

    // Récupérer les champs du formulaire
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("mot_passe").value.trim();

    // Variables pour suivre les erreurs
    var hasError = false;

    // Vérifier le champ email
    if (email === "") {
        document.getElementById("emailError").textContent = "Veuillez saisir votre adresse email.";
        hasError = true;
    }

    // Vérifier le champ mot de passe
    if (password === "") {
        document.getElementById("passwordError").textContent = "Veuillez saisir votre mot de passe";
        hasError = true;
    }

    // Si aucune erreur, soumettre le formulaire
    if (!hasError) {
        event.target.submit();
    }
}
document.getElementById("email").addEventListener("input",function()  {
    this.value=this.value.toLowerCase();
});
/********************************************************LA FONCTION DE RECHERCHE******************************************************************** */
function filterTable() {
    // Récupérer la valeur de l'input de recherche
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const table = document.getElementById('studentsTable');
    const rows = table.getElementsByTagName('tr');

    // Boucle à travers toutes les lignes du tableau (commençant à 1 pour ignorer l'en-tête)
    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;

        // Vérifiez si le contenu de chaque cellule correspond à la recherche
        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(searchInput)) {
                found = true;
                break;
            }
        }

        // Affiche ou cache la ligne selon le résultat de la recherche
        rows[i].style.display = found ? '' : 'none';
    }
}
/****************************************************Le pop up du recu*************************************************************************** */function openRecuPopup(eleveDetails, paiementDetails) {
    // Créer le contenu HTML pour le reçu
    function openRecuPopup(eleveDetails, paiementDetails) {
        // Créer le contenu HTML pour le reçu
        const contenu = `
            <div class="popup">
                <div class="popup-content">
                    <h2>Reçu de Paiement</h2>
                    <p><strong>Nom de l'élève:</strong> ${eleveDetails.nom}</p>
                    <p><strong>Matricule:</strong> ${eleveDetails.matricule}</p>
                    <p><strong>Classe:</strong> ${eleveDetails.classe}</p>
                    <p><strong>Montant payé:</strong> ${paiementDetails.montant} FCFA</p>
                    <p><strong>Mode de paiement:</strong> ${paiementDetails.mode_paiement}</p>
                    <button onclick="closePopup()">Fermer</button>
                </div>
            </div>
        `;
    
        // Ajouter le contenu au body
        document.body.insertAdjacentHTML('beforeend', contenu);
    }
    
    function closePopup() {
        const popup = document.querySelector('.popup');
        if (popup) {
            popup.remove();
        }
    }
 }    