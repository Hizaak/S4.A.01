<?php
// Inclusion du fichier contenant les informations de connexion à la base de données
require_once 'outils.php';
include_once 'Utilisateur.php';

class Formulaire {
    private static $instance;
    private $id;
    private $typeassos;
    private $date_debut;
    private $date_fin;
    
    private function __construct($id, $typeassos, $date_debut, $date_fin) {
        $this->id = $id;
        $this->typeassos = $typeassos;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
    }
    
    public static function getInstance($db) {
        if (is_null(self::$instance)) {
            // Récupération des données du formulaire
            $req = $db->query('SELECT * FROM formulaire');
            $row = $req->fetch(PDO::FETCH_ASSOC);

            self::$instance = new Formulaire($row['ID'], $row['TYPEASSOS'], $row['DATE_DEBUT'], $row['DATE_FINAL']);
        }
        
        return self::$instance;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getTypeassos() {
        return $this->typeassos;
    }
    
    public function getDateDebut() {
        return $this->date_debut;
    }
    
    public function getDateFin() {
        return $this->date_fin;
    }

    public function getEtat(Utilisateur $user, $db) {

        // Récupération des données du formulaire
        $req = $db->query('SELECT * FROM formulaire');
        $row = $req->fetch(PDO::FETCH_ASSOC);

        // if (!$row) {
        //     return 'formulaireInexistant';
        // }
        if ($row['DATE_FINAL'] < date('Y-m-d')) {
            if ($user->aReponduAuFormulaire($db)) {
                return 'peutConsulterEtRepondu';
            } else {
                return 'peutConsulterMaisPasRepondu';
            }
        } else {
            if ($user->aReponduAtousLeFormulaires($db)){
                //Si l'utilisateur a répondu à tout le formulaire
                return 'peutModifier';
            }
            else if($user->getNbQuestionRepondu($db)>0){
                return 'continueDeRepondre';
            }
            else{}
                return 'peutRepondre';
        }
    }

    public function existe($db) {
        // Récupération des données du formulaire
        $req = $db->query('SELECT * FROM formulaire');
        $row = $req->fetch(PDO::FETCH_ASSOC);
        if(!$row) {
            return false;
        } else {
            return true;
        }
    }

}

?>