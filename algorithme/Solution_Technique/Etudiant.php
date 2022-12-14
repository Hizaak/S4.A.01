
<?php

class Etudiant extends Utilisateur {

    //Attributs
    private $niveau;

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

}

?>