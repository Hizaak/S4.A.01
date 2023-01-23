
<?php
require_once "Utilisateur.php";
/**
 * @brief Classe Etudiant héritant de la classe Utilisateur
 * @author TauntiiO
 * @version 1.2
 * date : 2023-01-14
 */
class Etudiant extends Utilisateur {
    
    /**
     * @var int $niveau Le niveau de l'étudiant
     */
    private $niveau;
    
    /**
     * @var array $listeReponses Liste des réponses données par l'étudiant
     */
    private $listeReponses;

    /**
     * @brief Constructeur de la classe Etudiant
     *
     * @param string $login Le nom de connexion de l'étudiant
     * @param int $niveau Le niveau de l'étudiant
     */
    public function __construct($login, $niveau) {
        parent::__construct($login);
        $this->niveau = $niveau;
    }

    /**
     * @brief Obtenir le niveau de l'étudiant
     *
     * @return int Le niveau de l'étudiant
     */
    public function getNiveau() {
        return $this->niveau;
    }

    /**
     * @brief Définir le niveau de l'étudiant
     *
     * @param int $niveau Le nouveau niveau de l'étudiant
     */
    public function setNiveau($niveau) {
        $this->niveau = $niveau;
    }

    /**
     * @brief Obtenir la liste des réponses de l'étudiant
     *
     * @return array La liste des réponses de l'étudiant
     */
    public function getListeReponses() {
        return $this->listeReponses;
    }

    /**
     * @brief Définir la liste des réponses de l'étudiant
     *
     * @param array $listeReponses La nouvelle liste des réponses de l'étudiant
     */
    public function setListeReponses($listeReponses) {
        $this->listeReponses = $listeReponses;
    }

    /**
     * @brief Ajouter une réponse à la liste des réponses de l'étudiant
     *
     * @param mixed $reponse La réponse à ajouter à la liste
     */
    public function ajouterReponse($reponse) {
        $this->listeReponses[] = $reponse;
    }
}

?>