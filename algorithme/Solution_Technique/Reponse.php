
<?php

abstract class Reponse {

    //Attributs
    private $idQuestion;
    private $loginEtudiant;

    //Constructeur
    public function __construct($idQuestion, $loginEtudiant) {
        $this->idQuestion = $idQuestion;
        $this->loginEtudiant = $loginEtudiant;
    }

    //Encapsulation
    public function getIdQuestion() {
        return $this->idQuestion;
    }

    public function setIdQuestion($idQuestion) {
        $this->idQuestion = $idQuestion;
    }

    public function getloginEtudiant() {
        return $this->loginEtudiant;
    }

    public function setloginEtudiant($loginEtudiant) {
        $this->loginEtudiant = $loginEtudiant;
    }

}

?>