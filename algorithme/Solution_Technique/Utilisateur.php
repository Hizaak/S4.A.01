
<?php

/**
 * Description de la classe Utilisateur
 * @brief Classe Utilisateur abstraite
 * @author TauntiiO
 * @version 1.2
 * @date 2023-01-12
 * @see Etudiant
 * @see Admin
 */
abstract class Utilisateur {

    /**
     * @var string $login Le nom de connexion de l'utilisateur
     */
    private $login;

    /**
     * @brief Constructeur de la classe Utilisateur
     *
     * @param string $login Le nom de connexion de l'utilisateur
     */
    public function __construct($login) {
        $this->login = $login;
    }

    /**
     * @brief Obtenir le nom de connexion de l'utilisateur
     *
     * @return string Le nom de connexion de l'utilisateur
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * @brief Définir le nom de connexion de l'utilisateur
     *
     * @param string $login Le nouveau nom de connexion de l'utilisateur
     */
    public function setLogin($login) {
        $this->login = $login;
    }
}


?>