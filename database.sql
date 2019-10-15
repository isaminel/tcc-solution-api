CREATE TABLE IF NOT EXISTS `category` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_add` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `date_of_birth` DATETIME NOT NULL,
  `login` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_add` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

CREATE TABLE `idea` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_add` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `category`(`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `following` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `idea_id` INT(11) NOT NULL,
  `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_add` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`),
  FOREIGN KEY (`idea_id`) REFERENCES `idea`(`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

INSERT INTO `category` (`name`, `description`, `date_add`) VALUES
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


