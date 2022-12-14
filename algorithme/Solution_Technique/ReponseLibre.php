
<?php

require "Reponse.php";

class ReponseLibre extends Reponse {
    
        //Attributs
        private $reponseLibre;
    
        //Constructeur
        public function __construct($id, $idQuestion, $idEtudiant, $objetReponse, $reponseLibre) {
            parent::__construct($id, $idQuestion, $idEtudiant, $objetReponse);
            $this->reponseLibre = $reponseLibre;
        }
    
        //Encapsulation
        public function getReponseLibre() {
            return $this->reponseLibre;
        }
    
        public function setReponseLibre($reponseLibre) {
            $this->reponseLibre = $reponseLibre;
        }
}

?>