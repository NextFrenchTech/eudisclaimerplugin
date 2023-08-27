// Attente du chargement complet de la page avant d'exécuter du code jQuery
jQuery(document).ready(function($){
    // Vérification si un cookie spécifique n'a pas la valeur "AtTeNtIoNjEtEvOiS"
    if (lireUnCookie('eu-disclaimer-cookie') !== "AtTeNtIoNjEtEvOiS") {
        // Affichage de la modal avec certaines options de comportement
        $("#monModal").modal({
            escapeClose: false,  // Empêche la fermeture via la touche "Echap"
            clickClose: false,   // Empêche la fermeture en cliquant en dehors de la modal
            showClose: false     // Masque le bouton de fermeture de la modal
        });
    }
});

// Fonction pour créer un cookie avec un nom, une valeur et une durée en jours
function creerUnCookie(nomCookie, valeurCookie, dureeJours) {
    if (dureeJours) {
        // Créer une instance de Date pour calculer la date d'expiration
        var date = new Date();
        date.setTime(date.getTime() + (dureeJours * 24 * 60 * 60 * 1000)); // Calcul de la date d'expiration en millisecondes
        var expire = "; expires=" + date.toGMTString(); // Formatage de l'expiration pour le cookie
    } else {
        var expire = ""; // Si la durée n'est pas spécifiée, ne pas inclure d'expiration
    }
    // Création du cookie en utilisant le nom, la valeur et l'expiration
    document.cookie = nomCookie + "=" + valeurCookie + expire + "; path=/";
}

// Fonction pour lire la valeur d'un cookie en fonction de son nom
function lireUnCookie(nomCookie) {
    var nomFormate = nomCookie + "=";
    var tableauCookies = document.cookie.split(';');
    for (var i = 0; i < tableauCookies.length; i++) {
        var cookieTrouve = tableauCookies[i];
        while (cookieTrouve.charAt(0) == ' ') {
            cookieTrouve = cookieTrouve.substring(1, cookieTrouve.length); // Supprime les espaces au début
        }
        if (cookieTrouve.indexOf(nomFormate) == 0) {
            return cookieTrouve.substring(nomFormate.length, cookieTrouve.length); // Récupère la valeur du cookie
        }
    }
    return null; // Retourne null si le cookie n'est pas trouvé
}

// Ajout d'un écouteur d'événement au bouton ayant l'ID "actionDisclaimer"
document.getElementById("actionDisclaimer").addEventListener("click", accepterLeDisclaimer);

// Fonction exécutée lorsqu'on clique sur le bouton "Oui" de la modal
function accepterLeDisclaimer() {
    creerUnCookie('eu-disclaimer-cookie', "AtTeNtIoNjEtEvOiS", 1); // Création du cookie avec la valeur spécifiée et une durée d'un jour
    var cookie = lireUnCookie('eu-disclaimer-cookie'); // Lecture du cookie pour vérification
    alert(cookie); // Affichage de la valeur du cookie via une alerte
}
