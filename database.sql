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
  nb_of_seasons INT,
  description TEXT,
  image VARCHAR(250)
);

INSERT INTO serie (`id`, `name`,`year`,`nb_of_seasons`,`description`,`image`)
VALUES (1,'His Dark Materials',2019,3,'Deux enfants se lancent dans une aventure magique à travers des univers parallèles.','his_dark_materials.jpg'),
(2,'Game of Thrones',2011,8,'Neuf nobles familles se battent pour le contrôle des terres mythiques de Westeros, tandis qu\'un ancien ennemi revient après avoir été endormi pendant des milliers d\'années.','game_of_trones.jpg'),
(3,'The Mandalorian',2019,3,'La  série se déroule après la chute de l\'Empire et avant l\'émergence du Premier Ordre, et suit les épreuves d\'un tireur solitaire dans les confins de la galaxie, loin de l\'autorité de la Nouvelle République','the_mandalorian.webp'),
(4,'Minx',2022,1,'Dans les années 1970 à Los Angeles, une jeune féministe sérieuse s\'associe à un éditeur à loyer modique pour créer le premier magazine érotique pour femmes.','minx.webp'),
(5,'Friends',1994,10,'Suit les vies personnelles et professionnelles de six amis d''une vingtaine et trentaine d''années vivant à Manhattan.','friends.webp'),
(6,'The Big Bang Theory',2007,12,'Une jeune femme emménage dans l''appartement d''en face de deux physiciens brillants mais mal à l''aise en société et leur fait se rendre compte qu''ils ignorent presque tout de la vie en dehors de leur laboratoire.','the_big_bang_theory.jpg'),
(7,'The Walking Dead',2010,11,'Lorsque le shérif adjoint Rick Grimes sort du coma et apprend que le monde est en ruine, il doit aider un groupe de survivants à rester en vie.','the_walking_dead.jpg'),
(8,'Pushing Daisies',2007,2,'Un pâtissier qui a le pouvoir de ramener des morts à la vie résout des mystères de meurtre avec son amour d''enfance retrouvé, un enquêteur privé cynique et une serveuse malade d''amour.','pushing_daisies.jpg'),
(9,'Jessica Jones',2015,3,'Après la fin tragique de sa brève carrière de super-héros, Jessica Jones tente de reconstruire sa vie en tant qu''enquêteur privé, s''occupant de cas impliquant des personnes dotées de capacités remarquables à New York.','jessica_jones.jpg'),
(10,'La Flamme',2020,1,'Durant 9 semaines, 13 prétendantes vont devoir s''affronter dans une magnifique villa pour tenter de séduire Marc, pilote de ligne, recherchant l''amour. Laquelle de ces femmes réussira à allumer la flamme ?','la_flamme.jpg'),
(11,'Le seigneur des anneaux : Les anneaux de pouvoir',2022,1,'Série télévisée inspirée du Seigneur des Anneaux, se déroulant au cours de la période de 3 441 ans, connue sous le nom d''Age of Númenor, ou Second âge.','anneaux_pouvoir.jpg'),
(12,'Le Flambeau : les aventuriers de Chupacabra',2022,1,'Marc et quinze autres candidats s''affrontent et survivent sur une île. Des épreuves physiques et mentales seront imposées aux candidats.','le_flambeau.webp'),
(13, 'The Boys', 2019, 3, 'Une histoire d''action centrée sur une équipe de la CIA chargée de maintenir les super-héros en ligne, par tous les moyens nécessaires.', 'the_boys.jpg'),
(14,'Home for Christmas',2019,2,'Johanne, éternelle célibataire, va enfin amener un petit ami dans sa famille pour Noël! Mais quand elle se fait larguer, il ne lui reste que 24 jours pour le remplacer.','home_for_christmas.jpg'),
(15,'She-Hulk : Avocate','2023',1,'Les aventures de l''avocate Jennifer Walters, cousine de Bruce Banner, qui hérite de ses pouvoirs et devient Miss Hulk','she_hulk.jpeg'),
(16,'Arcane','2021',1,'Raconte l''intensification des tensions entre deux villes suite à l''apparition de nouvelles inventions qui menacent de provoquer une véritable révolution.','arcane.jpg');



CREATE TABLE style_tag (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL
);

INSERT INTO style_tag (`id`,`name`)
VALUES (1,'Aventure'),
(2,'Drame'),
(3,'Action'),
(4,'Comédie'),
(5,'Romantique');


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
VALUES (1,2),
(2,1),
(2,2),
(3,1),
(3,3),
(4,4),
(5,4),
(5,5),
(6,4),
(6,5),
(7,2),
(8,4),
(8,3),
(9,2),
(9,3),
(10,4),
(11,1),
(11,2),
(11,3),
(12,4),
(13,3),
(13,4),
(14,2),
(14,4),
(14,5),
(15,3),
(15,4),
(16,1),
(16,3);

