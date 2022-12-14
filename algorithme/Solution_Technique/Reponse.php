
<?php

class Reponse {

    //Attributs
    private $id;
    private $idEtudiant;
    private $objetReponse;

    //Constructeur
    public function __construct($id, $idEtudiant, $objetReponse) {
        $this->id = $id;
        $this->idEtudiant = $idEtudiant;
        $this->objetReponse = $objetReponse;
    }

    //Encpsulation
    public function getId() {
        return $this->id;
    }

    public function getIdEtudiant() {
        return $this->idEtudiant;
    }

    public function getObjetReponse() {
        return $this->objetReponse;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdEtudiant($idEtudiant) {
        $this->idEtudiant = $idEtudiant;
    }

    public function setObjetReponse($objetReponse) {
        $this->objetReponse = $objetReponse;
    }

}

?>