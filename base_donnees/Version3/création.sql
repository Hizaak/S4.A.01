/*On crée une table Utilisateur avec un login (clé primaire), un mot de passe NULL par default ,role,et un niveau et sa validité*/
CREATE TABLE Utilisateur (
    login VARCHAR(64) PRIMARY KEY,
    password VARCHAR(64) DEFAULT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    niveau INT(11),
    valide ENUM('oui','non') DEFAULT 'non'
);

/*On crée une table Formulaire avec id (auto incrémental),un enum TypeQuestion pouvant etre ("auto","1","2") et une date de debut et de fin*/
CREATE TABLE Formulaire (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    TypeQuestion ENUM('auto','1','2'),
    date_debut DATE,
    date_final DATE
);

/*On crée une table Question avec un id(auto incrémental), l'objetPHP de type blob, l'id du formulaire (clé etrangere), 
visibilité enum ("all","1","2") et typeQuestion enum ("QCM","LIBRE")*/
CREATE TABLE Question (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    objetPHP BLOB,
    id_formulaire INT(11),
    visibilite ENUM('all','1','2'),
    typeQuestion ENUM('QCM','LIBRE'),
    FOREIGN KEY (id_formulaire) REFERENCES Formulaire(id)
);


/*On crée une table Question qui utilise l'id de la question et le login de l'utilisateur comme clé primaire,ainsi que l'objet réponse blob*/
CREATE TABLE Reponse (
    id_question INT(11),
    login VARCHAR(64),
    objetReponse BLOB,
    PRIMARY KEY (id_question,login),
    FOREIGN KEY (id_question) REFERENCES Question(id),
    FOREIGN KEY (login) REFERENCES Utilisateur(login)
);


/*On crée une table PARRAINE qui utilise le login( parrain et filleul) de deux utilisateurs comme clé primaire
On ajout une contrainte comme quoi le parrain doit etre de niveau 2 et le filleul de niveau 1*/
CREATE TABLE PARRAINE (
    login_parrain VARCHAR(64),
    login_filleul VARCHAR(64),
    PRIMARY KEY (login_parrain,login_filleul),
    FOREIGN KEY (login_parrain) REFERENCES Utilisateur(login),
    FOREIGN KEY (login_filleul) REFERENCES Utilisateur(login)
    /* A REPARER
    CONSTRAINT parrain_niveau CHECK (login_parrain IN (SELECT login FROM Utilisateur WHERE niveau=2)),
    CONSTRAINT filleul_niveau CHECK (login_filleul IN (SELECT login FROM Utilisateur WHERE niveau=1))*/
);






-- DROP TABLE IF EXISTS PARRAINE;
-- DROP TABLE IF EXISTS Reponse;
-- DROP TABLE IF EXISTS Question;
-- DROP TABLE IF EXISTS Formulaire;
-- DROP TABLE IF EXISTS Utilisateur;