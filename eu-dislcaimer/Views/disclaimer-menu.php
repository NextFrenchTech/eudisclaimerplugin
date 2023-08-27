<?php

// Vérifier si les champs 'message_disclaimer' et 'url_redirection' du formulaire ne sont pas vides.
if (!empty($_POST['message_disclaimer']) && !empty($_POST['url_redirection'])) {
    // Créer une instance de la classe DisclaimerOptions.
    $text = new DisclaimerOptions();
    // Définir le message du disclaimer en utilisant les données du champ 'message_disclaimer' du formulaire.
    $text->setMessageDisclaimer(htmlspecialchars($_POST['message_disclaimer']));
    // Définir l'URL de redirection en cas de refus en utilisant les données du champ 'url_redirection' du formulaire.
    $text->setRedirectionKo(htmlspecialchars($_POST['url_redirection']));
    // Insérer les données dans la table en utilisant la méthode statique 'insererDansTable' de DisclaimerGestionTable.
    $message = DisclaimerGestionTable::insererDansTable($text);
}

?>

<h1>EU-DISCLAIMER</h1>
<br />
<h2>Configuration</h2>
<form method="post" action="" novalidate="novalidate">
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="message_disclaimer">Message du disclaimer</label>
            </th>
            <td>
                <input type="text" name="message_disclaimer" id="message_disclaimer" value="" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="url_redirection">URL de redirection</label>
            </th>
            <td>
                <input type="text" name="url_redirection" id="url_redirection" value="" class="regular-text" />
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button button-primary" value="Enregistrer les modifications" />
    </p>
</form>
<p><?php if (isset($message)) echo $message; ?></p>
<br />
<h3>
    Maxime Callac / Session DWWM
</h3>
<img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/img/eu-disclaimer-18.png'; ?>" width="10%" alt="oups..." />


<!-- Message à ajouter en cas d'utilisation du shortcode -->
<!--<p>
    Comment afficher le plugin ? <br />
    Vous pouvez ajouter le shortcode [eu-disclaimer] dans un article ou une page
</p>-->
