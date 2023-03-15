
<?php

require_once "Reponse.php";

/**
 * Description de la classe ReponseLibre
 * @brief Classe ReponseLibre héritant de la classe Reponse
 * @author TauntiiO
 * @version 1.2
 * @date 2023-01-14
 * @see Reponse
 * @see ReponseQCM
 */
class ReponseLibre extends Reponse {
    
    /**
     * @var string $reponseLibre La réponse à la question à réponse libre
     */
    private $reponseLibre;

    /**
     * @brief Constructeur de la classe ReponseLibre
     *
     * @param int $idQuestion L'identifiant de la question
     * @param int $idEtudiant L'identifiant de l'étudiant
     * @param string $reponseLibre La réponse à la question à réponse libre
     */
    public function __construct($idQuestion, $idEtudiant, $reponseLibre) {
        parent::__construct($idQuestion, $idEtudiant);
        $this->reponseLibre = $reponseLibre;
    }

    /**
     * @brief Obtenir la réponse à réponse libre
     *
     * @return string La réponse à réponse libre
     */
    public function getReponseLibre() {
        return $this->reponseLibre;
    }

    /**
     * @brief Définir la réponse à réponse libre
     *
     * @param string $reponseLibre La nouvelle réponse à réponse libre
     */
    public function setReponseLibre($reponseLibre) {
        $this->reponseLibre = $reponseLibre;
    }

    /**
     * @brief Afficher la réponse à réponse libre
     *
     */
    public function afficherReponse() {
        echo $this->reponseLibre;
    }
}


?>