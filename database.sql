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
  `id` int(11) NOT NULL AUTO_INCREMENT,
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

INSERT INTO `category` (`name`, `date_add`) VALUES
('Engenharia de Software', '2019-09-17 20:05:00'),
('Robótica', '2019-09-17 20:05:00'),
('IoT', '2019-09-17 20:05:00'),
('Inteligência Artificial', '2019-09-17 20:05:00'),
('Literatura', '2019-09-17 20:05:00'),
('Automação', '2019-09-17 20:05:00')
('Mecânica', '2019-09-17 20:05:00');

INSERT INTO `user` (`name`, `email`, `date_of_birth`, `login`, `password`, `date_add`) VALUES
('Isabelle', 'isabelleminel@gmail.com', '1998-04-10 16:15:00', 'isaminel', '123', '2019-09-17 20:05:00');