<?php

// Définir le chemin du plugin en tant que constante
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
// Inclure le fichier disclaimer-options.php
include(MY_PLUGIN_PATH . '../Entity/disclaimer-options.php');

class DisclaimerGestionTable {

    // Méthode pour créer la table de gestion des disclaimers
    public function creerTable() {
        // Instancier la classe DisclaimerOptions
        $message = new DisclaimerOptions();

        // Alimenter l'objet du message avec des données par défaut
        $message->setMessageDisclaimer("Au regard de la loi européenne, vous devez nous confirmer que vous avez plus de 18 ans pour visiter ce site !");
        $message->setRedirectionKo("https://www.cnil.fr/fr/particulier");
        
        global $wpdb;

        // Créer la table de gestion des disclaimers
        $tableDisclaimer = $wpdb->prefix . 'disclaimer_options';
        if ($wpdb->get_var("SHOW TABLES LIKE $tableDisclaimer") != $tableDisclaimer) {
            // La table n'existe pas déjà

            // Définir la requête SQL pour la création de la table
            $sql = "CREATE TABLE $tableDisclaimer 
                (id_disclaimer INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                message_disclaimer TEXT NOT NULL, 
                redirection_ko TEXT NOT NULL)
                ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            
            // Afficher un message d'erreur en cas d'échec de la création de la table
            if (!$wpdb->query($sql)) {
                die("Une erreur est survenue, contactez le développeur du plugin...");
            }

            // Insérer le message par défaut dans la table
            $wpdb->insert(
                $tableDisclaimer, array(
                    'message_disclaimer' => $message->getMessageDisclaimer(),
                    'redirection_ko'=> $message->getRedirectionKo(),
                ), array('%s', '%s'));
            $wpdb->query($sql);
        }
    }

    // Méthode pour supprimer la table de gestion des disclaimers
    public function supprimerTable() {

        global $wpdb;

        // Supprimer la table
        $tableDisclaimer = $wpdb->prefix . 'disclaimer_options';
        $sql = "DROP TABLE $tableDisclaimer";
        $wpdb->query($sql);
    }

    // Méthode statique pour insérer des données dans la table
    static function insererDansTable(DisclaimerOptions $option) {

        $message_inserer_valeur = '';

        global $wpdb;

        try {
            $tableDisclaimer = $wpdb->prefix . 'disclaimer_options';
            $sql = $wpdb->prepare(
            "UPDATE $tableDisclaimer SET message_disclaimer = '%s', redirection_ko = '%s' WHERE id_disclaimer = '%s'",
            $option->getMessageDisclaimer(),$option->getRedirectionKo(),1);
            $wpdb->query($sql);
            return $message_inserer_valeur = '<span style="color:green; font-size:16px;">Les données ont correctement été mises à jour !</span>';
        }
        catch(Exception $e) {
            return $message_inserer_valeur = '<span style="color:red; font-size:16px;">Une erreur est survenue !</span>';
        }
    }
    
    // Méthode statique pour afficher les données dans une modal
    static function AfficherDonneModal() {

        global $wpdb;

        // Récupérer les données pour afficher la modal
        $tableDisclaimer = $wpdb->prefix . 'disclaimer_options';
        $query = "SELECT * from " . $tableDisclaimer;
        $row = $wpdb->get_row($query);
        $message_disclaimer = $row->message_disclaimer;
        $lien_redirection = $row->redirection_ko;

        // Retourner le code HTML de la modal
        return '<div id="monModal" class="modal">
                    <p>Nous vous souhaitons la bienvenue !</p>
                    <p>'. $message_disclaimer . '</p>
                    <a href="' . $lien_redirection . '" type="button" class="btn-red">Non</a>
                    <a href="#" type="button" rel="modal:close" class="btn-green" id="actionDisclaimer">Oui</a> 
                </div>';
    }
}

?>
