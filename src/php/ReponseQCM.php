
<?php

require_once "Reponse.php";
/**
* Description de la classe ReponseQCM
* @brief Classe ReponseQCM héritant de la classe Reponse
* @author TauntiiO
* @version 1.2
* @date 2023-01-14
* @see Reponse
*/
class ReponseQCM extends Reponse{
        
    /**
     * @var string $reponseQCM La réponse à la question QCM
     */
    private $reponseQCM;
    
    /**
     * Constructeur
     *
     * @param int $idQuestion L'identifiant de la question
     * @param int $idEtudiant L'identifiant de l'étudiant
     * @param string $reponseQCM La réponse à la question QCM
     */
    public function __construct($idQuestion, $idEtudiant, $reponseQCM) {
        parent::__construct($idQuestion, $idEtudiant);
        $this->reponseQCM = $reponseQCM;
    }
    
    /**
     * @brief Obtenir la réponse QCM
     *
     * @return string La réponse QCM
     */
    public function getReponseQCM() {
        return $this->reponseQCM;
    }
    
    /**
     * @brief Définir la réponse QCM
     *
     * @param string $reponseQCM La nouvelle réponse QCM
     */
    public function setReponseQCM($reponseQCM) {
        $this->reponseQCM = $reponseQCM;
    }

    /**
     * @brief Afficher la réponse QCM
     *
     */
    public function afficherReponse() {
        for ($i = 0; $i < count($this->reponseQCM); $i++) {
            echo $this->reponseQCM[$i];
            echo " ";
        }
    }
}

?>