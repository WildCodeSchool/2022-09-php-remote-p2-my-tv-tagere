CREATE TABLE user (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  lastname VARCHAR(80),
  firstname VARCHAR(80),
  birthdate DATE,
  email VARCHAR(255) NOT NULL,
  `password` varchar(20) NOT NULL
);

CREATE TABLE serie (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  `year` YEAR,
  nb_of_seasons TINYINT,
  description TEXT,
  image VARCHAR(250)
);

CREATE TABLE style_tag (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL
);

CREATE TABLE user_serie (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  serie_id INT,
  nb_of_seen_seasons TINYINT,
  CONSTRAINT fk_user_serie2 FOREIGN KEY (serie_id) REFERENCES serie(id),
  CONSTRAINT fk_user_serie1 FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE serie_style_tag (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  serie_id INT,
  style_tag_id INT,
  CONSTRAINT fk_serie_style_tag1 FOREIGN KEY (serie_id) REFERENCES serie(id),
  CONSTRAINT fk_serie_style_tag2 FOREIGN KEY (style_tag_id) REFERENCES style_tag(id)
);
