
CREATE TABLE `playlist` ( 
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `nom` VARCHAR( 255 ) NOT NULL);



CREATE TABLE `titre` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `nom` VARCHAR( 255 ) NOT NULL ,
    `artiste` VARCHAR( 255 ) NOT NULL ,
    `genre` VARCHAR( 255 ) NOT NULL ,
    `note` INT NOT NULL);


CREATE TABLE `appartient` ( 
    `idTitre` INT NOT NULL ,
    `idPlaylist` INT NOT NULL,
    FOREIGN KEY (idTitre) REFERENCES titre(id),
    FOREIGN KEY (idPlaylist) REFERENCES playlist(id) ); 



INSERT INTO titre (artiste, nom, genre, note) VALUES ('Rihanna', 'Umbrella', 'pop', 3),
('JuiceWRLD', 'Face-off', 'rap', 5),
('Rihanna', 'Disturbia', 'pop', 4),
('Kendrick Lamar', 'DNA', 'rap', 3),
('shaka ponk', 'Bunker', 'rock', 4),
('Ziak', 'akimbo', 'rap', 3),
('Ziak', 'raspoutine', 'rap', 5),
('Lil Pump', 'Gucci Gang', 'rap', 2),
('xxxTentacion', 'SAD!', 'rap', 4),
('xxxTentacion', 'changes', 'rap', 3),
('Lil Uzi Vert', 'XO Tour Llif3', 'rap', 5),
('Alberto','dwutakt', 'rap', 4),
('Evan', 'Voyage', 'rap', 3),
('Jaco Pastorius', 'Portrait of Tracy', 'jazz', 0),
('Wejedene','aliça', 'rap', 0),
('Pink floyd', 'Wish you were here', 'rock', 3),
('kanye west', 'power', 'rap', 4),
('Ariana Grande', '7 rings', 'pop', 5),
('Genesis', 'Follow you follow me', 'rock', 3),
('The beatles', 'Hey Jude', 'rock', 4),
('Rammstein', 'Du hast', 'rock', 5),
('ACDC', 'Thunderstruck', 'rock', 3),
('The weeknd', 'Starboy', 'pop', 4),
('Bjork', 'Hyperballad', 'pop', 5),
('Michael Jackson', 'Billie Jean', 'pop', 3),
('Sia', 'Chandelier', 'pop', 4),
('Three Day Grace','Get out alive','rock',5),
('Three Day Grace','Me against you','rock',5),
('Three Day Grace','Never too late','rock',5),
('Three Day Grace','Pain','rock',5),
('Three Day Grace','Riot','rock',5),
('Three Day Grace','The high road','rock',5),
('Three Day Grace','World so cold','rock',5),
('Stevie wonder','Superstition','jazz',5),
('Stevie wonder','Sir duke','jazz',5),
('Stevie wonder','I wish','jazz',5),
('Stevie wonder','Isn’t she lovely','jazz',5),
('Stevie wonder','As','jazz',5);


INSERT INTO playlist (nom) VALUES ('sport'), ('ambiance'), ('fight'), ('cozi');

INSERT INTO appartient (idTitre, idPlaylist) SELECT id, 1 FROM titre WHERE genre = 'rap';
INSERT INTO appartient (idTitre, idPlaylist) SELECT id, 2 FROM titre WHERE genre = 'pop';
INSERT INTO appartient (idTitre, idPlaylist) SELECT id, 3 FROM titre WHERE genre = 'rock';
INSERT INTO appartient (idTitre, idPlaylist) SELECT id, 4 FROM titre WHERE genre = 'jazz';
