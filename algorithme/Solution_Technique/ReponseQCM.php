
<?php

require "Reponse.php";

class ReponseQCM extends Reponse{
        
        //Attributs
        private $reponseQCM;
        
        //Constructeur
        public function __construct($id, $idQuestion, $idEtudiant, $objetReponse, $reponseQCM) {
            parent::__construct($id, $idQuestion, $idEtudiant, $objetReponse);
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