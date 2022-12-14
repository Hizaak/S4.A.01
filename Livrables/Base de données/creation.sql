/* On crée une table Utilisateur avec un login (clé primaire), un mot de passe NULL par default ,role,et un niveau et sa validité */
CREATE TABLE UTILISATEUR (
    LOGIN VARCHAR(64) PRIMARY KEY,
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

/* On crée une table Question avec un id(auto incrémental), l'objetPHP de type blob, l'id du formulaire (clé etrangere), 
visibilité enum ("all","1","2") et typeQuestion enum ("QCM","LIBRE") */
CREATE TABLE QUESTION (
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    OBJETPHP BLOB,
    ID_FORMULAIRE INT(11),
    VISIBILITE ENUM('all', '1', '2'),
    TYPEQUESTION ENUM('QCM', 'LIBRE'),
    FOREIGN KEY (ID_FORMULAIRE) REFERENCES FORMULAIRE(ID)
);

/* On crée une table Question qui utilise l'id de la question et le login de l'utilisateur comme clé primaire,ainsi que l'objet réponse blob */
CREATE TABLE REPONSE (
    ID_QUESTION INT(11),
    LOGIN VARCHAR(64),
    OBJETREPONSE BLOB,
    PRIMARY KEY (ID_QUESTION, LOGIN),
    FOREIGN KEY (ID_QUESTION) REFERENCES QUESTION(ID),
    FOREIGN KEY (LOGIN) REFERENCES UTILISATEUR(LOGIN)
);

/* On crée une table PARRAINE qui utilise le login( parrain et filleul) de deux utilisateurs comme clé primaire
On ajout une contrainte comme quoi le parrain doit etre de niveau 2 et le filleul de niveau 1 */
CREATE TABLE PARRAINE (
    LOGIN_PARRAIN VARCHAR(64),
    LOGIN_FILLEUL VARCHAR(64),
    PRIMARY KEY (LOGIN_PARRAIN, LOGIN_FILLEUL),
    FOREIGN KEY (LOGIN_PARRAIN) REFERENCES UTILISATEUR(LOGIN),
    FOREIGN KEY (LOGIN_FILLEUL) REFERENCES UTILISATEUR(LOGIN)
 /* A REPARER
    CONSTRAINT parrain_niveau CHECK (login_parrain IN (SELECT login FROM Utilisateur WHERE niveau=2)),
    CONSTRAINT filleul_niveau CHECK (login_filleul IN (SELECT login FROM Utilisateur WHERE niveau=1)) */
);

-- DROP TABLE IF EXISTS PARRAINE;
-- DROP TABLE IF EXISTS Reponse;
-- DROP TABLE IF EXISTS Question;
-- DROP TABLE IF EXISTS Formulaire;
-- DROP TABLE IF EXISTS Utilisateur;