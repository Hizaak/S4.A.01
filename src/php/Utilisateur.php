
<?php
// Inclusion du fichier contenant les informations de connexion à la base de données
include_once 'outils.php';

class Utilisateur {
    private $login;
    private $role;
    private $estValide;
    private $niveau = null;
    private $nom;
    private $prenom;
    private $listeReponses = array();

    // GETTERS
    public function getLogin() { return $this->login; }
    public function getRole() { return $this->role; }
    public function estValide() { return $this->estValide; }
    public function getNiveau() { return $this->niveau; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }

    
    // SETTERS
    public function setLogin($login) { $this->login = $login; }
    public function setRole($role) { $this->role = $role; }
    public function setEstValide($estValide) { $this->estValide = $estValide; }
    public function setNiveau($niveau) { $this->niveau = $niveau; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }

    // METHODES
    public function estAdmin() { return $this->role == 'admin'; }

    // Constructeur depuis la base de données (login)
    public function __construct($login,$db) {
        // Récupération des données de l'utilisateur
        $req = $db->prepare('SELECT * FROM utilisateur WHERE LOGIN = :login');
        $req->execute(array('login' => $login));
        $row = $req->fetch();

        if (!$row) {
            throw new Exception('Utilisateur inexistant');
        }

        $this->login = $login;
        $this->role = $row['ROLE'];
        $this->estValide = $row['VALIDE'];
        $this->nom = $row['NOM'];
        $this->prenom = $row['PRENOM'];

    }

    public function getListeReponses($db){
        //TODO : A REFAIRE NE FONCTIONNE PLUS
        $req = $db->prepare('SELECT ID_QUESTION, REPONSE FROM repondre WHERE LOGIN = :login');
        $req->execute(array('login' => $this->getLogin()));
        return $req->fetch(PDO::FETCH_ASSOC);
    }


    public function aReponduAuFormulaire($db){
        //A DISCUTER
        $req1 = $db->prepare('SELECT login FROM repondreQCM WHERE LOGIN = :login');
        $req1->execute(array('login' => $this->getLogin()));
        $req2 = $db->prepare('SELECT login FROM repondreLibre WHERE LOGIN = :login');
        $req2->execute(array('login' => $this->getLogin()));
        if($req1->fetch(PDO::FETCH_ASSOC || $req2->fetch(PDO::FETCH_ASSOC))){
            return true;
        }
        else{
            return false;
        }
    }

    public function getNbQuestionRepondu($db){
        $req=$db->prepare("SELECT ID_QUESTION FROM repondreQCM WHERE LOGIN=:leftlogin UNION SELECT ID_QUESTION FROM repondreLibre WHERE LOGIN=:rightlogin");
        $req->execute(array("leftlogin"=>$this->getLogin(),"rightlogin"=>$this->getLogin()));
        return $req->rowCount();
    }

    public function getNBQuestionARepondre($db){
        $req=$db->prepare("SELECT ID FROM question WHERE VISIBILITE='all' OR VISIBILITE IN (SELECT NIVEAU FROM utilisateur WHERE LOGIN=:login)");
        $req->execute(array("login"=>$this->getLogin()));
        return $req->rowCount();
    }

    public function aReponduAtousLeFormulaires($db){
        return $this->getNbQuestionRepondu($db)==$this->getNBQuestionARepondre($db);
    }



}
?>