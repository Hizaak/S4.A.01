
<?php
// Inclusion du fichier contenant les informations de connexion à la base de données
include_once 'outils.php';

abstract class Utilisateur {
    private $login;
    private $role;
    private $estValide;

    // GETTERS
    public function getLogin() {
        return $this->login;
    }
    
    public function getEstValide() {
        return $this->estValide;
    }
    
    // SETTERS
    public function setLogin($login) {
        $this->login = $login;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setEstValide($estValide) {
        $this->estValide = $estValide;
    }

    // METHODES
    public function estAdmin() {
        return $this->role == 'admin';
    }

    public function estValide() {
        return $this->estValide;
    }

    // Constructeur depuis la base de données (login)
    public function __construct($login) {
        global $database;
        // Récupération des données de l'utilisateur
        $stmt = $database->prepare('SELECT * FROM utilisateur WHERE LOGIN = :login');
        $stmt->execute(array('login' => $login));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new Exception('Utilisateur inexistant');
        }

        $this->login = $login;
        $this->role = $row['ROLE'];
        $this->estValide = $row['EST_VALIDE'];
    }
}
?>