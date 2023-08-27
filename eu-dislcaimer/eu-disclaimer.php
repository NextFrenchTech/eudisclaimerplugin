<?php

// Déclarer les constantes à utiliser dans le plugin

/**
 * Plugin Name: eu-disclaimer
 * Plugin URI: http://URL_de_l_extension
 * Description: Afficher un disclaimer (avertissement) sur votre site WordPress.
 * Version: 1.5
 * Author: Maxime Callac
 * Author URI: https://eu-disclaimer-plugIn
 * Licence: Open Source
 */

// Si ces informations ne sont pas fournies, elles seront automatiquement complétées avec vos données.

// Inclure le fichier de gestion de la base de données du plugin.
require_once("Model/Repository/disclaimer-gestion-table.php");

// Créer la fonction "addMenuPage" pour ajouter une entrée de menu dans l'interface d'administration.

function addMenuPage() {
    $page = "eu-disclaimer";
    $menu = "eu-disclaimer";
    $capacity = "edit_pages";
    $slug = "eu-disclaimer";
    $function = "euDisclaimerFonction";
    $icon = "";
    $position = 65; // Placer l'entrée dans le menu juste en dessous de "Extensions"
    
    if (is_admin()) {
        // Ajouter la page et rendre le lien visible dans le menu d'administration.
        add_menu_page($page, $menu, $capacity, $slug, $function, $icon, $position);
    }
}

// Ajouter la fonction "addMenuPage" à l'action "admin_menu".
add_action("admin_menu", "addMenuPage", 10);

/* Fonctions du plugin */

// Afficher le contenu de la page du plugin.
function euDisclaimerFonction(){
    require_once ("Views/disclaimer-menu.php");
}

// Vérifier si la classe "DisclaimerGestionTable" existe avant de l'instancier.

if (class_exists("DisclaimerGestionTable")) {
    $gerer_table = new DisclaimerGestionTable();
} 
 
if (isset($gerer_table)) {
    // Créer la table en base de données lors de l'activation du plugin.
    register_activation_hook(__FILE__, array($gerer_table, 'creerTable')); 
    // Supprimer la table en base de données lors de la désactivation du plugin.
    register_deactivation_hook(__FILE__, array($gerer_table, 'supprimerTable'));
}

// Intégrer le modal jQuery via CDN (CSS).
add_action('wp_head', 'ajouter_css', 1);

function ajouter_css() {
    if (!is_admin()) :
        // Enregistrer et ajouter le style du modal jQuery.
        wp_register_style('modal', 
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css', 
        null, null, false);
        wp_enqueue_style('modal');
        // Enregistrer et ajouter le style CSS spécifique au plugin.
        wp_register_style('eu-disclaimer-css', 
        plugins_url('assets/css/eu-disclaimer-css.css', __FILE__), 
        null, null, false);
        wp_enqueue_style('eu-disclaimer-css');
    endif;
}

// Intégrer le modal jQuery via CDN (JS).
add_action('init', 'inserer_js_dans_footer');

function inserer_js_dans_footer() {
    if (!is_admin()) :
        // Enregistrer et ajouter la bibliothèque jQuery via CDN.
        wp_register_script('jQuery', 
        'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js',
        null, null, true);
        wp_enqueue_script('jQuery');
        // Enregistrer et ajouter le script du modal jQuery via CDN.
        wp_register_script('jQuery_modal', 
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js', 
        null, null, true);
        wp_enqueue_script('jQuery_modal');
        // Enregistrer et ajouter le script JavaScript spécifique au plugin.
        wp_register_script('jQuery_eu', 
        plugins_url('assets/js/eu-disclaimer-js.js', __FILE__), 
        null, null, true);
        wp_enqueue_script('jQuery_eu');
    endif;
}

// Afficher le modal dans le corps (body) de la page.
add_action( 'wp_body_open', 'afficherModalDansBody');
function afficherModalDansBody(){
    echo DisclaimerGestionTable::AfficherDonneModal();
}

/*// Afficher le modal dans un shortcode
add_shortcode( 'eu_disclaimer', 'afficherModalDansShortcode');
function afficherModalDansShortcode(){
    echo DisclaimerGestionTable::AfficherDonneModal();
}*/

/*// Shortcode à ajouter sous la balise (body) de la page.
<?php echo do_shortcode ('[eu-disclaimer]'); ?>*/

?>
