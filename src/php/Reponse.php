
<?php
/**
 * Description de la classe Reponse
 * @brief Classe Reponse abstraite 
 * @author TauntiiO
 * @version 1.2
 * @date  2023-01-12
 * @see ReponseQCM
 * @see ReponseLibre

 */
abstract class Reponse {

    /**
     * @var int $idQuestion L'identifiant de la question
     */
    private $idQuestion;
    
    /**
     * @var string $loginEtudiant Le nom de connexion de l'étudiant
     */
    private $loginEtudiant;

    /**
     * @brief Constructeur de la classe Reponse
     *
     * @param int $idQuestion L'identifiant de la question
     * @param string $loginEtudiant Le nom de connexion de l'étudiant
     */
    public function __construct($idQuestion, $loginEtudiant) {
        $this->idQuestion = $idQuestion;
        $this->loginEtudiant = $loginEtudiant;
    }

    /**
     * @brief Obtenir l'identifiant de la question
     *
     * @return int L'identifiant de la question
     */
    public function getIdQuestion() {
        return $this->idQuestion;
    }

    /**
     * @brief Définir l'identifiant de la question
     *
     * @param int $idQuestion Le nouvel identifiant de la question
     */
    public function setIdQuestion($idQuestion) {
        $this->idQuestion = $idQuestion;
    }

    /**
     * @brief Obtenir le nom de connexion de l'étudiant
     *
     * @return string Le nom de connexion de l'étudiant
     */
    public function getloginEtudiant() {
        return $this->loginEtudiant;
    }

    /**
     * @brief Définir le nom de connexion de l'étudiant
     *
     * @param string $loginEtudiant Le nouveau nom de connexion de l'étudiant
     */
    public function setloginEtudiant($loginEtudiant) {
        $this->loginEtudiant = $loginEtudiant;
    }

    /**
     * @brief Méthode abstraite pour afficher la réponse
     */
    public abstract function afficherReponse();

}


?>