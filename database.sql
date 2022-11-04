CREATE TABLE user (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  lastname VARCHAR(80),
  firstname VARCHAR(80),
  birthdate DATE,
  email VARCHAR(255) NOT NULL
);

INSERT INTO `user` (`lastname`, `firstname`, `birthdate`, `email`)
VALUES ('Floflo', 'Florian', '1970-12-25', 'floflo.florian@serial.com'),
('Nem', 'Emeric', '1989-08-03', 'floflo.florian@serial.com'),
('Dupond','jean','2021-01-02','jean.dupond@tralala.com');


CREATE TABLE serie (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  `year` YEAR,
  nb_of_seasons TINYINT,
  description TEXT,
  image VARCHAR(250)
);

INSERT INTO serie (`name`,`year`,`nb_of_seasons`,`description`,`image`)
VALUES ('His Dark Materials',2019,3,'Deux enfants se lancent dans une aventure magique à travers des univers parallèles.','his_dark_materials.jpg'),
('Game of Thrones',2011,8,'Neuf nobles familles se battent pour le contrôle des terres mythiques de Westeros, tandis qu\'un ancien ennemi revient après avoir été endormi pendant des milliers d\'années.','game_of_trones.jpg'),
('The Mandalorian',2019,3,'La  série se déroule après la chute de l\'Empire et avant l\'émergence du Premier Ordre, et suit les épreuves d\'un tireur solitaire dans les confins de la galaxie, loin de l\'autorité de la Nouvelle République','the_mandalorian.webp'),
('Minx',2022,1,'Dans les années 1970 à Los Angeles, une jeune féministe sérieuse s\'associe à un éditeur à loyer modique pour créer le premier magazine érotique pour femmes.','minx.webp');


CREATE TABLE style_tag (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL
);

INSERT INTO style_tag (`name`)
VALUES ('Aventure'),
('Drame'),
('Action'),
('Comédie');


CREATE TABLE user_serie (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  serie_id INT,
  nb_of_seen_seasons TINYINT,
  CONSTRAINT fk_user_serie2 FOREIGN KEY (serie_id) REFERENCES serie(id),
  CONSTRAINT fk_user_serie1 FOREIGN KEY (user_id) REFERENCES user(id)
);

INSERT INTO user_serie (`user_id`,`serie_id`,`nb_of_seen_seasons`)
VALUES (1,1,2);


CREATE TABLE serie_style_tag (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  serie_id INT,
  style_tag_id INT,
  CONSTRAINT fk_serie_style_tag1 FOREIGN KEY (serie_id) REFERENCES serie(id),
  CONSTRAINT fk_serie_style_tag2 FOREIGN KEY (style_tag_id) REFERENCES style_tag(id)
);


INSERT INTO serie_style_tag (`serie_id`,`style_tag_id`)
VALUES (1,1,2),
(2,2,1),
(3,2,2),
(4,3,1),
(5,3,3),
(6,4,4);
