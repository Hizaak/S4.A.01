
<?php

abstract class Reponse {

    //Attributs
    private $id;
    private $idQuestion;
    private $idEtudiant;

    //Constructeur
    public function __construct($id, $idQuestion, $idEtudiant) {
        $this->id = $id;
        $this->idQuestion = $idQuestion;
        $this->idEtudiant = $idEtudiant;
    }

    //Encapsulation
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdQuestion() {
        return $this->idQuestion;
    }

    public function setIdQuestion($idQuestion) {
        $this->idQuestion = $idQuestion;
    }

    public function getIdEtudiant() {
        return $this->idEtudiant;
    }

    public function setIdEtudiant($idEtudiant) {
        $this->idEtudiant = $idEtudiant;
    }

}

?>