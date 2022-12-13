
<?php

class Reponse {

    //Attributs
    private $id;
    private $idEtudiant;
    
    //Constructeur
    public function Reponse($id, $idEtudiant) {
        $this->id = $id;
        $this->idEtudiant = $idEtudiant;
    }

    //Encapsulation
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdEtudiant() {
        return $this->idEtudiant;
    }

    public function setIdEtudiant($idEtudiant) {
        $this->idEtudiant = $idEtudiant;
    }

}

?>