document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    form.addEventListener("submit", function(event) {
        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const cin = document.getElementById("cin").value.trim();
        const tel = document.getElementById("tel").value.trim();
        const checkin = document.getElementById("checkin").value.trim();
        const checkout = document.getElementById("checkout").value.trim();
        const currentDate = new Date().toISOString().split('T')[0]; // Récupérer la date système

        // Vérification du nom
        if (!isValidName(name)) {
            alert("Veuillez saisir un nom composé de deux chaînes de caractères séparées par un espace.");
            event.preventDefault();
            return;
        }

        // Vérification du CIN
        if (!isValidCIN(cin)) {
            alert("Le CIN doit être composé de 8 chiffres exactement.");
            event.preventDefault();
            return;
        }

        // Vérification du téléphone
        if (!isValidTel(tel)) {
            alert("Le numéro de téléphone doit être composé de 8 chiffres exactement.");
            event.preventDefault();
            return;
        }

        // Vérification que la date d'arrivée n'est pas passée
        if (checkin < currentDate) {
            alert("La date d'arrivée ne peut pas être antérieure à la date système.");
            event.preventDefault();
            return;
        }

        // Vérification que la date de départ n'est pas passée
        if (checkout < currentDate) {
            alert("La date de départ ne peut pas être antérieure à la date système.");
            event.preventDefault();
            return;
        }

        // Vérification que la date de départ est postérieure à la date d'arrivée
        if (checkout <= checkin) {
            alert("La date de départ doit être ultérieure à la date d'arrivée.");
            event.preventDefault();
            return;
        }

        // Vérification de l'email
        if (!isValidEmail(email)) {
            alert("Veuillez saisir une adresse email valide.");
            event.preventDefault();
            return;
        }

        // Vérification si une réservation existe déjà avec cet email
        if (reservationExists(email)) {
            alert("Une réservation existe déjà avec cet email.");
            event.preventDefault();
            return;
        }
    });

    // Fonction pour valider le format du nom
    function isValidName(name) {
        const nameRegex = /^[A-Za-z]+\s[A-Za-z]+$/;
        return nameRegex.test(name);
    }

    // Fonction pour valider le format du CIN
    function isValidCIN(cin) {
        const cinRegex = /^\d{8}$/;
        return cinRegex.test(cin);
    }

    // Fonction pour valider le format du téléphone
    function isValidTel(tel) {
        const telRegex = /^\d{8}$/;
        return telRegex.test(tel);
    }

    // Fonction pour valider le format de l'email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Fonction pour vérifier si une réservation existe déjà avec cet email
    function reservationExists(email) {
        const existingEmails = document.querySelectorAll('.existing-email');
        for (let i = 0; i < existingEmails.length; i++) {
            if (existingEmails[i].innerText === email) {
                return true;
            }
        }
        return false;
    }
});
