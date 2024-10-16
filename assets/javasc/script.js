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
