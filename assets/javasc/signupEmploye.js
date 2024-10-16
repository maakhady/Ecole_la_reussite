
document.getElementById('menuToggle').addEventListener('click', function() {
    var sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active'); // Basculer la classe active
});

// Écouteur d'événements pour le changement du mot de passe
document.addEventListener("DOMContentLoaded", function () {
const togglePassword = document.getElementById('togglePassword');
const passwordField = document.getElementById('password');
const toggleIcon = document.getElementById('togglePasswordIcon');

togglePassword.addEventListener("click", function () {
    // Bascule le type de l'input entre 'password' et 'text'
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
});
});



document.getElementById('role').addEventListener('change', function() {
    var matiereFields = document.getElementById("matiere-fields");
    var classeFields = document.getElementById("classe-fields");

    var role = this.value;
    var passwordSection = document.getElementById('mot_de_passe_section');
    var teacherSection = document.getElementById('teacher_section');
    if (role == '1' || role == '2' || role == '3'|| role == '4' || role == '5') {
        passwordSection.style.display = 'block';
    } else {
        passwordSection.style.display = 'none';
    }
    if(role == '3'){
        teacherSection.style.display = 'block';
        matiereFields.style.display = 'block';
        classeFields.style.display = 'none';
    } else if(role == '4'){
        teacherSection.style.display = 'block';
        matiereFields.style.display = 'none';
        classeFields.style.display = 'block';
    } else {
        teacherSection.style.display = 'none';
    }
});
document.getElementById("myForm").addEventListener("submit", function(event) {
// Empêche la soumission par défaut du formulaire


// Récupère les valeurs des champs et les messages d'erreur
const fields = {
    name: document.getElementById("name"),
    email: document.getElementById("email"),
    firstname: document.getElementById("prenom"),
    phone: document.getElementById("phone"),
    role: document.getElementById("role"),
    password: document.getElementById("password"),
    date: document.getElementById("date"),
    matiere1: document.getElementById("matiere1"),
    matiere2: document.getElementById("matiere2"),
    classe: document.getElementById("classe")
};

const errors = {
    name: document.getElementById("error-name"),
    email: document.getElementById("error-email"),
    firstname: document.getElementById("error-prenom"),
    phone: document.getElementById("error-phone"),
    role: document.getElementById("error-role"),
    password: document.getElementById("error-password"),
    date: document.getElementById("error-date"),
    matiere2: document.getElementById("error-matiere2"),
    matiere1: document.getElementById("error-matiere1"),
    mail2: document.getElementById("mail-doublon"),
    tel2: document.getElementById("tel-doublon"),
    classe: document.getElementById("error-classe")
};

// Réinitialise les messages d'erreur
Object.values(errors).forEach(error => error.textContent = "");

let hasError = false;
const currentDate = new Date();
const birthDate = new Date(fields.date.value);
const maxDate = new Date("2006-01-31");

// Validation des champs
if (birthDate > maxDate) {
    errors.date.textContent = "La date de naissance ne doit pas dépasser le 31 janvier 2006.";
    hasError = true;
}

if (errors.mail2.textContext || errors.tel2.textContext){
    hasError = true;
}

if (fields.role.value === '3'){
if (fields.matiere1.value === fields.matiere2.value) {
    errors.matiere2.textContent = "Veuillez choisir deux matières différentes.";
    hasError = true;
}
if (fields.matiere1.value ==="Choisissez une matière"){
    errors.matiere1.textContent = "La premiere matiere est obligatoire";
    hasError = true;
}
}

if (fields.role.value === '4'){
    if (fields.classe.value ==="Choisissez une classe"){
    errors.classe.textContent = "Le choix d'une classe est obligatoire";
    hasError = true;
}
}

if (!fields.name.value.trim()) {
    errors.name.textContent = "Le nom est requis.";
    hasError = true;
}

if (!fields.firstname.value.trim()) {
    errors.firstname.textContent = "Le prénom est requis.";
    hasError = true;
}

if (!fields.phone.value.trim() || fields.phone.value < 700000000 || fields.phone.value > 789999999) {
    errors.phone.textContent = "Numéro de téléphone non valide.";
    hasError = true;
}

if (fields.role.value === "Veuillez choisir une fonction") {
    errors.role.textContent = "Le rôle est requis.";
    hasError = true;
}

if (['1', '2', '3', '4', '5'].includes(fields.role.value) && !fields.password.value.trim()) {
    errors.password.textContent = "Le mot de passe est requis.";
    hasError = true;
}

if (!fields.date.value.trim()) {
    errors.date.textContent = "La date est requise.";
    hasError = true;
}

if (!fields.email.value.trim() || !validateEmail(fields.email.value)) {
    errors.email.textContent = "Veuillez entrer un email valide.";
    hasError = true;
}

if(hasError){
    event.preventDefault();
}

// Si aucune erreur, soumission du formulaire
if (!hasError) {
    event.target.submit();
}
});

// Fonction de validation d'email
function validateEmail(email) {
const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
return re.test(String(email).toLowerCase());
}
