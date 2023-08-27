<?php

class DisclaimerOptions {

    private $id_disclaimer; // Identifiant du disclaimer
    private $message_disclaimer; // Contenu du message à afficher dans le disclaimer
    private $redirection_ko; // URL de redirection en cas de réponse négative par le visiteur

    // Constructeur de la classe DisclaimerOptions
    function __construct($id_disclaimer = "Nc", $message_disclaimer = "Nc", $redirection_ko = "Nc") {
        $this->id_disclaimer = $id_disclaimer;
        $this->message_disclaimer = $message_disclaimer;
        $this->redirection_ko = $redirection_ko;
    }

    /**
     * Getter pour l'identifiant du disclaimer
     */
    public function getIdDisclaimer()
    {
        return $this->id_disclaimer;
    }

    /**
     * Setter pour l'identifiant du disclaimer
     */
    public function setIdDisclaimer($id_disclaimer): self
    {
        $this->id_disclaimer = $id_disclaimer;

        return $this;
    }

    /**
     * Getter pour le contenu du message du disclaimer
     */
    public function getMessageDisclaimer()
    {
        return $this->message_disclaimer;
    }

    /**
     * Setter pour le contenu du message du disclaimer
     */
    public function setMessageDisclaimer($message_disclaimer): self
    {
        $this->message_disclaimer = $message_disclaimer;

        return $this;
    }

    /**
     * Getter pour l'URL de redirection en cas de réponse négative
     */
    public function getRedirectionKo()
    {
        return $this->redirection_ko;
    }

    /**
     * Setter pour l'URL de redirection en cas de réponse négative
     */
    public function setRedirectionKo($redirection_ko): self
    {
        $this->redirection_ko = $redirection_ko;

        return $this;
    }
}

?>
