
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
        $this->estValide = $row['EST_VALIDE'];
        $this->nom = $row['NOM'];
        $this->prenom = $row['PRENOM'];


    }

    public function getListeReponses($db){
        $req = $db->prepare('SELECT ID_QUESTION, REPONSE FROM repondre WHERE LOGIN = :login');
        $req->execute(array('login' => $this->getLogin()));
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function aRepondu(){
        return !empty($this->listeReponses);
    }


}
?>