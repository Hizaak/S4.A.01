
<?php

require_once "Reponse.php";

class ReponseLibre extends Reponse {
    
        //Attributs
        private $reponseLibre;
    
        //Constructeur
        public function __construct($idQuestion, $idEtudiant, $reponseLibre) {
            parent::__construct($idQuestion, $idEtudiant);
            $this->reponseLibre = $reponseLibre;
        }
    
        //Encapsulation
        public function getReponseLibre() {
            return $this->reponseLibre;
        }
    
        public function setReponseLibre($reponseLibre) {
            $this->reponseLibre = $reponseLibre;
        }

        //Méthodes

        public function afficherReponse() {
            echo $this->reponseLibre;
        }
}

?>