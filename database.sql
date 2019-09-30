CREATE TABLE IF NOT EXISTS `team` (
    `team_id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `slogan` VARCHAR(255),
    `institution` VARCHAR(255),
    `email` VARCHAR(255) NOT NULL,
    `website` VARCHAR(255) NOT NULL,
    `country` VARCHAR(100) NOT NULL,
    `state` VARCHAR(255) NOT NULL,
    `city` VARCHAR(255) NOT NULL,
    `image` VARCHAR(255),
    `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_add` DATETIME NOT NULL,
    PRIMARY KEY (`team_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `event` (
    `event_id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255),
    `city` VARCHAR(255),
    `state` VARCHAR(255),
    `country` VARCHAR(100),
    `website` VARCHAR(255),
    `email` VARCHAR(255),
    `image` VARCHAR(255),
    `date_start` DATETIME NOT NULL,
    `date_end` DATETIME NOT NULL,
    `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_add` DATETIME NOT NULL,
    PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `category` (
    `category_id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_add` DATETIME NOT NULL,
    PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `event_category` (
  `event_category_id` INT(11) NOT NULL AUTO_INCREMENT,
  `event_id` INT(11) NOT NULL,
  `category_id` INT(11) NOT NULL,
  PRIMARY KEY (`event_category_id`),
  FOREIGN KEY (`category_id`) REFERENCES `category`(`category_id`),
  FOREIGN KEY (`event_id`) REFERENCES `event`(`event_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `person_type` (
  `person_type_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255),
  PRIMARY KEY (`person_type_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `person` (
  `person_id` INT(11) NOT NULL AUTO_INCREMENT,
  `person_type_id` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `rg` VARCHAR(15) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `date_of_birth` DATETIME NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_add` DATETIME NOT NULL,
  `photo` VARCHAR(255),
  `team_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  FOREIGN KEY (`team_id`) REFERENCES `team`(`team_id`),
  FOREIGN KEY (`person_type_id`) REFERENCES `person_type`(`person_type_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `robot` (
  `robot_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `category_id` INT(11) NOT NULL,
  `photo` VARCHAR(255),
  `team_id` INT(11) NOT NULL,
  `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_add` DATETIME NOT NULL,
  PRIMARY KEY (`robot_id`),
  FOREIGN KEY (`team_id`) REFERENCES `team`(`team_id`),
  FOREIGN KEY (`category_id`) REFERENCES `category`(`category_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `event_person` (
  `event_person_id` INT(11) NOT NULL AUTO_INCREMENT,
  `event_id` INT(11) NOT NULL,
  `person_id` INT(11) NOT NULL,
  PRIMARY KEY (`event_person_id`),
  FOREIGN KEY (`person_id`) REFERENCES `person`(`person_id`),
  FOREIGN KEY (`event_id`) REFERENCES `event`(`event_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `event_robot` (
  `event_robot_id` INT(11) NOT NULL AUTO_INCREMENT,
  `event_id` INT(11) NOT NULL,
  `robot_id` INT(11) NOT NULL,
  PRIMARY KEY (`event_robot_id`),
  FOREIGN KEY (`robot_id`) REFERENCES `robot`(`robot_id`),
  FOREIGN KEY (`event_id`) REFERENCES `event`(`event_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

INSERT INTO `category` (`name`, `date_add`) VALUES
('Sumô Mini - 500g Junior', '2019-09-17 20:05:00'),
('Sumô Mini - 500g Autônomo', '2019-09-17 20:05:00'),
('Sumô - 1kg Lego', '2019-09-17 20:05:00'),
('Sumô - 3kg Autônomo', '2019-09-17 20:05:00'),
('Sumô - 3kg R/C', '2019-09-17 20:05:00'),
('Seguidor de Linha - Júnior', '2019-09-17 20:05:00'),
('Seguidor de Linha - Pro', '2019-09-17 20:05:00'),
('Trekking - Pro', '2019-09-17 20:05:00'),
('Combate Antweight - 1lb (454g) - Júnior', '2019-09-17 20:05:00'),
('Combate Antweight - 1lb (454g)', '2019-09-17 20:05:00'),
('Combate Beetleweight - 3lb (1,36kg)', '2019-09-17 20:05:00'),
('Combate Hobbyweight - 12lb (5,44kg)', '2019-09-17 20:05:00'),
('Futebol - Simulação 2D', '2019-09-17 20:05:00'),
('Futebol - Very Small Size League', '2019-09-17 20:05:00'),
('Futebol - Very Small Size League R/C', '2019-09-17 20:05:00'),
('Artbot - Kinetic', '2019-09-17 20:05:00'),
('Hockey', '2019-09-17 20:05:00');

INSERT INTO `person_type` (`name`, `description`) VALUES
('Participante', 'Participante do Evento'),
('Visitante', 'Visitante não-competidor'),
('Juíz', 'Juíz do evento'),
('Capitão', 'Capitão de equipe'),
('Voluntário', 'Voluntário não-juíz');

INSERT INTO `event` (`name`, `date_start`, `date_end`, `date_add`)
VALUES
('II Summit de Robótica Católica-SC', '2019-11-15 00:00:00', '2019-11-17 23:59:59', '2019-09-25 00:00:00');

INSERT INTO `event_category` (`event_id`, `category_id`) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7),
(1, 8), (1, 9), (1, 10), (1, 11), (1, 12),  (1, 17);

