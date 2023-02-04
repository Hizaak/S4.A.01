/* On crée une table Utilisateur avec un login (clé primaire), un mot de passe NULL par default ,role,et un niveau et sa validité */
CREATE TABLE UTILISATEUR (
    LOGIN VARCHAR(64) PRIMARY KEY,
    NOM VARCHAR(64) DEFAULT NULL,
    PRENOM VARCHAR(64) DEFAULT NULL,
    PASSWORD VARCHAR(64) DEFAULT NULL,
    ROLE ENUM('admin', 'user') DEFAULT 'user',
    NIVEAU INT(11),
    VALIDE ENUM('oui', 'non') DEFAULT 'non'
);

/* On crée une table Formulaire avec id (auto incrémental),un enum TypeQuestion pouvant etre ("auto","1","2") et une date de debut et de fin */
CREATE TABLE FORMULAIRE (
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    TYPEQUESTION ENUM('auto', '1', '2'),
    DATE_DEBUT DATE,
    DATE_FINAL DATE
);

/* On crée une table Question avec un id(auto incrémental),un ititulé,l'id de son formulaire,le chemin vers l'image,par qui il est visible,le type de la question,le nombre de proposition possible si QCM,
le nombre de caractère max si LIBRE*/
CREATE TABLE QUESTION (
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    INTITULE VARCHAR(50) NOT NULL,
    ID_FORMULAIRE INT(11),
    IMAGE VARCHAR(260) DEFAULT '..\\sources\\images\\imgplaceholder.jpg',
    VISIBILITE ENUM('all', '1', '2'),
    TYPEQUESTION ENUM('QCM', 'LIBRE'),
    NBREPONSE INT(11) DEFAULT 1,
    NBCARACTEREMAX INT(11) DEFAULT 255,
    FOREIGN KEY (ID_FORMULAIRE) REFERENCES FORMULAIRE(ID)
);



/*On crée une table proposition qui stock toute les proposition de réponse d'une Question, une couleur et son texte  */
CREATE TABLE Proposition(
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    TEXTE VARCHAR(500) NOT NULL,
    COULEUR VARCHAR(7) DEFAULT '#808080',
    ID_QUESTION INT(11),
    FOREIGN KEY (ID_QUESTION) REFERENCES QUESTION(ID)
);

/* On crée une table Question qui utilise l'id de la question et le login de l'utilisateur comme clé primaire,ainsi que le contenu de la réponse */
CREATE TABLE REPONDRE (
    ID_QUESTION INT(11),
    LOGIN VARCHAR(64),
    REPONSE VARCHAR(500) NOT NULL,
    PRIMARY KEY (ID_QUESTION, LOGIN),
    FOREIGN KEY (ID_QUESTION) REFERENCES QUESTION(ID),
    FOREIGN KEY (LOGIN) REFERENCES UTILISATEUR(LOGIN)
);

/* On crée une table PARRAINER qui utilise le login( parrain et filleul) de deux utilisateurs comme clé primaire
On ajout une contrainte comme quoi le parrain doit etre de niveau 2 et le filleul de niveau 1 */
CREATE TABLE PARRAINER (
    LOGIN_PARRAIN VARCHAR(64),
    LOGIN_FILLEUL VARCHAR(64),
    PRIMARY KEY (LOGIN_PARRAIN, LOGIN_FILLEUL),
    FOREIGN KEY (LOGIN_PARRAIN) REFERENCES UTILISATEUR(LOGIN),
    FOREIGN KEY (LOGIN_FILLEUL) REFERENCES UTILISATEUR(LOGIN)
);




-- DROP TABLE IF EXISTS PARRAINER;
-- DROP TABLE IF EXISTS Proposition;
-- DROP TABLE IF EXISTS Repondre;
-- DROP TABLE IF EXISTS Question;
-- DROP TABLE IF EXISTS Formulaire;
-- DROP TABLE IF EXISTS Utilisateur;


-- schema relationnel
Utilisateur( login, nom, prenom, password, role, niveau, valide)