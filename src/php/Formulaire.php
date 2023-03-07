<?php
// Inclusion du fichier contenant les informations de connexion à la base de données
include_once 'outils.php';
include_once 'Etudiant.php';

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
    
    public static function getInstance() {
        if (is_null(self::$instance)) {
            global $database;
            // Récupération des données du formulaire
            $stmt = $database->query('SELECT * FROM formulaire');
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

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

    public function getEtat(Etudiant $etudiant) {
        // Inclusion du fichier contenant les informations de connexion à la base de données
        global $database;

        // Récupération des données du formulaire
        $stmt = $database->query('SELECT * FROM formulaire');
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return 'formulaireInexistant';
        }
        if ($row['DATE_FINAL'] < date('Y-m-d')) {
            if ($etudiant->aRepondu()) {
                return 'peutConsulterEtRepondu';
            } else {
                return 'peutConsulterMaisPasRepondu';
            }
        } else {
            if ($etudiant->aRepondu()) {
                return 'peutModifier';
            } else {
                return 'peutRepondre';
            }
        }
    }
    public function existe() {
        // Inclusion du fichier contenant les informations de connexion à la base de données
        global $database;

        // Récupération des données du formulaire
        $stmt = $database->query('SELECT * FROM formulaire');
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

}

?>