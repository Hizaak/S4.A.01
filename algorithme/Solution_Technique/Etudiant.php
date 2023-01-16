
<?php

require "Utilisateur.php";

class Etudiant extends Utilisateur {

    //Attributs

    private $niveau;
    private $listeReponses = array();

    //Constructeur
    
    public function __construct($login, $niveau) {
        parent::__construct($login);
        $this->niveau = $niveau;
    }

    //Encapsulation

    public function getNiveau() {
        return $this->niveau;
    }

    public function setNiveau($niveau) {
        $this->niveau = $niveau;
    }

    public function getListeReponses() {
        return $this->listeReponses;
    }

    public function setListeReponses($listeReponses) {
        $this->listeReponses = $listeReponses;
    }

    //Méthodes

    public function ajouterReponse($reponse) {
        $this->listeReponses[] = $reponse;
    }

}

?>