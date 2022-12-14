------------------FORMULAIRE-----------

-- Le compte administrateur pourra créer un formulaire avec un type d'association et les dates de debut et de fin
INSERT INTO Formulaire(typeAssociation,DateDebut,DateFin) VALUES(':type',':dateDebut',':dateFin');

-- Le compte administrateur pourra modifier un formulaire
UPDATE Formulaire SET typeAssociation = ':type', DateDebut = ':dateDebut', DateFin = ':dateFin';

-- Le compte administrateur pourra supprimer un formulaire
DELETE FROM Formulaire WHERE idFormulaire = ':idFormulaire';


------------------QUESTION-----------

-- On créer une question avec Son object PHP et les informatons du formulaire auquel elle appartient
INSERT INTO Question (ObjectQuestion,idFormulaire,TypeQuestion) VALUES(':object',':idFormulaire',':typeQuestion');

-- On modifie une question avec Son object PHP sans changer les autres informations 
UPDATE Question SET ObjectQuestion = ':object';


------------------REPONSE-----------

-- On créer une réponse avec Son object PHP et les informatons de la question auquel elle appartient
INSERT INTO Reponse (ObjectReponse,idQuestion,loginUser) VALUES(':object',':idQuestion',':loginUser');

-- On modifie une réponse avec Son object PHP sans changer les autres informations
UPDATE Reponse SET ObjectReponse = ':object';


-----------------Utilisateur-----------

-- Le compte administrateur pourra uploader des fichier CSV des étudiants d'une promotion,
-- Donc pour chaque éléments du CSV un étudiant sera inseré
INSERT INTO Utilisateur(login,password,role,promo,estValide) VALUES (':login','', 'user', ':promo',0);

-- L'utilisateur crée n'a pas de mot de passe par default est n'est donc pas valide
-- pour le validé, l'utilisateur doit "créer" son compte, donc on ne fait que Update l'occurence
UPDATE Utilisateur SET password = :password, estValide = 1 WHERE login = :login;

-- L'utilisateur crée n'a pas de mot de passe par default est n'est donc pas valide
-- pour le validé, l'utilisateur doit "créer" son compte, donc on ne fait que Update l'occurence
UPDATE Utilisateur SET password = :password, estValide = 1 WHERE login = :login;

-- Pour la connexion, on vérifie que l'utilisateur existe et que son mot de passe est valide
SELECT * FROM Utilisateur WHERE login = :login;

-- Si l'utilisateur souhaite suprimmer son compte, on le supprime pas mais reset tout ces attributs
UPDATE Utilisateur SET estValide=0, password='', role='user', promo='' WHERE login=:login;


-----------------Parraine-----------

-- Une fois l'association faite, on associera les deux utilisateurs
INSERT INTO Parraine(loginUser,loginParrain) VALUES(':loginUser',':loginParrain');