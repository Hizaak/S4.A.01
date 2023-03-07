
<?php
require_once "Utilisateur.php";
require_once "outils.php";
require_once "baseDeDonnees.php";



/**
 * @brief Classe Etudiant héritant de la classe Utilisateur
 * @author TauntiiO
 * @version 1.2
 * date 2023-01-14
 */
class Etudiant extends Utilisateur
{
    private $nom;
    private $prenom;
    private $niveau;

    // GETTERS
    public function getNom(){
        return $this->nom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getNiveau(){
        return $this->niveau;
    }

    public function getListeReponses(){
        global $database;
        $stmt = $database->prepare('SELECT ID_QUESTION, REPONSE FROM repondre WHERE LOGIN = :login');
        $stmt->execute(array('login' => $this->getLogin()));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // SETTERS
    public function setNom($nom){
        $this->nom = $nom;
    }

    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }

    public function setNiveau($niveau){
        $this->niveau = $niveau;
    }

    public function setListeReponses($listeReponses){
        $this->listeReponses = $listeReponses;
    }

    // METHODES
    public function ajouterReponse($id,$reponse){
        $this->listeReponses[$id] = $reponse;
    }



    // Definir la liste de reponses depuis la base de donnes

    // Constructeur depuis la base de données (login)
    public function __construct($login){
        parent::__construct($login);
        global $database;
        // Récupération des données de l'étudiant
        $stmt = $database->prepare('SELECT * FROM etudiant WHERE LOGIN = :login');
        $stmt->execute(array('login' => $login));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new Exception('Etudiant inexistant');
        }

        $this->nom = $row['NOM'];
        $this->prenom = $row['PRENOM'];
        $this->niveau = $row['NIVEAU'];
        // La listeReponse n'est pas récupérée ici, mais dans la méthode getListeReponses()
    }
    


    public function aRepondu(){
        return count($this->listeReponses) > 0;
    }
}

?>