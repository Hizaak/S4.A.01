
<?php

abstract class Utilisateur {

    //Attributs
    private $login;

    //Constructeur
    public function __construct($login) {
        $this->login = $login;
    }

    //Encapsulation
    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

}

?>