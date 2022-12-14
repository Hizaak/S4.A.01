
<?php

class Etudiant {

    //Attributs
    private $id;
    private $nom;
    private $niveau;

    //Constructeur
    public function __construct($id, $nom, $niveau) {
        $this->id = $id;
        $this->nom = $nom;
        $this->niveau = $niveau;
    }

    //Encpsulation
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getNiveau() {
        return $this->niveau;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setNiveau($niveau) {
        $this->niveau = $niveau;
    }

}

?>