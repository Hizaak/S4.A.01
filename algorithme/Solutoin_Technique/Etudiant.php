
<?php

class Etudiant {

    //Attributs
    private $id;

    //Constructeur
    public function Etudiant($id) {
        $this->id = $id;
    }

    //Encapsulation
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

}

?>