
<?php

class Etudiant {

    //Attributs
    private $id;
    private $login;
    private $niveau;

    //Constructeur
    public function __construct($id, $login, $niveau) {
        $this->id = $id;
        $this->login = $login;
        $this->niveau = $niveau;
    }

    //Encpsulation
    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getNiveau() {
        return $this->niveau;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setNiveau($niveau) {
        $this->niveau = $niveau;
    }

}

?>