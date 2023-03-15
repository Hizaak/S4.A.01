<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header('Location:accueil.php');
}

class Database{
    private static $instance = null;
    private $db;

    private function __construct($db_servername, $db_username, $db_password, $db_name)
    {
        try
        {
            $this->db = new PDO('mysql:host='.$db_servername.';dbname='.$db_name.';charset=utf8', ''.$db_username.'', ''.$db_password.'');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public static function getInstance($db_servername, $db_username, $db_password, $db_name)
    {
        if (self::$instance == null)
        {
            self::$instance = new Database($db_servername, $db_username, $db_password, $db_name);
        }
        return self::$instance;
    }

    public function getDb()
    {
        return $this->db;
    }
}

$db_servername = "localhost";
$db_username = "hegolagunak";
$db_password = "S4.01hegolagunak";
$db_name = "hegolagunak";

$database = Database::getInstance($db_servername, $db_username, $db_password, $db_name)->getDb();
?>