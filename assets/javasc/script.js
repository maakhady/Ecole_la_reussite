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
 /*************************************CONVERSION DU MONTANT FINAL EN LETTRE************************************************** */
 

 function nombreEnLettres(nombre) {
    const unites = ["", "un", "deux", "trois", "quatre", "cinq", "six", "sept", "huit", "neuf", "dix", 
                   "onze", "douze", "treize", "quatorze", "quinze", "seize", "dix-sept", "dix-huit", "dix-neuf"];
    const dizaines = ["", "", "vingt", "trente", "quarante", "cinquante", "soixante", "soixante-dix", "quatre-vingt", "quatre-vingt-dix"];

    if (nombre == 0) {
        return "zéro";
    }

    if (nombre < 20) {
        return unites[nombre];
    }

    if (nombre < 100) {
        if (nombre % 10 === 0) {
            return dizaines[Math.floor(nombre / 10)];
        } else if (nombre < 70 || (nombre >= 80 && nombre < 90)) {
            return dizaines[Math.floor(nombre / 10)] + "-" + unites[nombre % 10];
        } else if (nombre < 80) {
            return "soixante-" + unites[nombre % 20];
        } else {
            return "quatre-vingt-" + unites[nombre % 20];
        }
    }

    if (nombre < 1000) {
        if (nombre === 100) {
            return "cent";
        } else if (nombre < 200) {
            return "cent " + nombreEnLettres(nombre % 100);
        } else {
            return unites[Math.floor(nombre / 100)] + " cent" + (nombre % 100 === 0 ? "" : " " + nombreEnLettres(nombre % 100));
        }
    }

    if (nombre < 1000000) {
        if (nombre === 1000) {
            return "mille";
        } else if (nombre < 2000) {
            return "mille " + nombreEnLettres(nombre % 1000);
        } else {
            return nombreEnLettres(Math.floor(nombre / 1000)) + " mille" + (nombre % 1000 === 0 ? "" : " " + nombreEnLettres(nombre % 1000));
        }
    }

    return "Nombre trop grand";
}

let montant = 1234;
console.log(nombreEnLettres(montant).charAt(0).toUpperCase() + nombreEnLettres(montant).slice(1) + ' francs CFA');
