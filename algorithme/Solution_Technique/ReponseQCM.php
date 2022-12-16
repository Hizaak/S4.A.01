
<?php

require "Reponse.php";

class ReponseQCM extends Reponse{
        
        //Attributs
        private $reponseQCM;
        
        //Constructeur
        public function __construct($idQuestion, $idEtudiant, $reponseQCM) {
            parent::__construct($idQuestion, $idEtudiant);
            $this->reponseQCM = $reponseQCM;
        }
        
        //Encapsulation
        public function getReponseQCM() {
            return $this->reponseQCM;
        }
        
        public function setReponseQCM($reponseQCM) {
            $this->reponseQCM = $reponseQCM;
        }
}

?>