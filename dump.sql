CREATE TABLE `site` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rewrite` varchar(250) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `module` varchar(100) DEFAULT NULL,
  `controller` varchar(100) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `params` varchar(100) NOT NULL DEFAULT '[]',
  `text` text NOT NULL,
  `description` varchar(250) NOT NULL DEFAULT '',
  `keywords` varchar(250) NOT NULL DEFAULT '',
  `bg_image` varchar(100) DEFAULT NULL,
  `trash` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rewrite` (`rewrite`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `site` (`id`, `rewrite`, `name`, `module`, `controller`, `action`, `params`, `text`, `description`, `keywords`, `bg_image`, `trash`) VALUES
(1, '/', 'Home', 'content', 'content', 'index', '[1]', '', 'A Blog Theme by Start Bootstrap', 'A Blog Theme by Start Bootstrap', 'home-bg.jpg', '0'),
(2, '/about.html', 'About Me', NULL, NULL, NULL, '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe nostrum ullam eveniet pariatur voluptates odit, fuga atque ea nobis sit soluta odio, adipisci quas excepturi maxime quae totam ducimus consectetur?\n\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Eius praesentium recusandae illo eaque architecto error, repellendus iusto reprehenderit, doloribus, minus sunt. Numquam at quae voluptatum in officia voluptas voluptatibus, minus!\n\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Aut consequuntur magnam, excepturi aliquid ex itaque esse est vero natus quae optio aperiam soluta voluptatibus corporis atque iste neque sit tempora!', 'This is what I do.', 'This is what I do.', 'about-bg.jpg', '0'),
(3, '/post.html', 'Man must explore, and this is exploration at its greatest', 'content', 'content', 'item', '[1]', '', 'Problems look mighty small from 150 miles up\n', 'Problems look mighty small from 150 miles up\n', 'post-bg.jpg', '0'),
(4, '/contact.html', 'Contact Me', 'contact', 'contact', 'index', '[]', '', 'Problems look mighty small from 150 miles up\n', 'Problems look mighty small from 150 miles up\n', 'contact-bg.jpg', '0');


CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'идентификатор',
  `login` varchar(60) NOT NULL DEFAULT '' COMMENT 'Логин',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'Имя',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT 'пароль в зашифрованном виде',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT 'e-mail',
  `role` enum('admin','user') DEFAULT 'user' NULL COMMENT 'Роль',
  `trash` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'запись удалена в корзину: 0 - нет, 1 - да',
  PRIMARY KEY (`id`),
  KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='Пользователи';

INSERT INTO cms.users (login,name,password,email,`role`,trash) VALUES ('admin', 'Админ', 'd2abaa37a7c3db1137d385e1d8c15fd2', 'admin@gmail.com', 'admin', '0');

CREATE TABLE `content` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'идентификатор',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'название',
  `text` longtext COMMENT 'контент',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'пользователь из таблицы `users`',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'подрядковый номер для сортировки',
  `trash` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'запись удалена в корзину: 0 - нет, 1 - да',
  `created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Страницы сайта';

--
-- Дамп данных таблицы `content`
--

INSERT INTO `content` (`id`, `name`, `text`, `user_id`, `sort`, `trash`, `created_dt`) VALUES
(1, 'Failure is not an option', 'Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center — an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.\n\nScience cuts two ways, of course; its products can be used for both good and evil. But there\'s no turning back from science. The early warnings about technological dangers also come from science.\n\nWhat was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.\n\nA Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.\n\nFor those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.\n\nThe Final Frontier\nThere can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.\n\nThere can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.\n\nThe dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.\nSpaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.\n\nReaching for the Stars\nAs we got further and further away, it [the Earth] diminished in size. Finally it shrank to the size of a marble, the most beautiful you can imagine. That beautiful, warm, living object looked so fragile, so delicate, that if you touched it with a finger it would crumble and fall apart. Seeing this has to change a man.', 1, 0, '0', '2018-04-16 14:11:40'),
(2, 'Science has not yet mastered prophecy', 'Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center — an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.\n\nScience cuts two ways, of course; its products can be used for both good and evil. But there\'s no turning back from science. The early warnings about technological dangers also come from science.\n\nWhat was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.\n\nA Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.\n\nFor those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.\n\nThe Final Frontier\nThere can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.\n\nThere can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.\n\nThe dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.\nSpaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.', 1, 1, '0', '2018-04-16 14:11:40'),
(3, 'I believe every human has a finite number of heartbeats. I don\'t intend to waste any of mine.', 'Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center — an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.\n\nScience cuts two ways, of course; its products can be used for both good and evil. But there\'s no turning back from science. The early warnings about technological dangers also come from science.\n\nWhat was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.\n\nA Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.\n\nFor those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.\n\nThe Final Frontier\nThere can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.\n\nThere can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.\n\nThe dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.\nSpaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.', 1, 2, '0', '2018-04-16 14:11:40'),
(4, 'Man must explore, and this is exploration at its greatest', 'Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center — an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.\n\nScience cuts two ways, of course; its products can be used for both good and evil. But there\'s no turning back from science. The early warnings about technological dangers also come from science.\n\nWhat was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.\n\nA Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.\n\nFor those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.\n\nThe Final Frontier\nThere can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.\n\nThere can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.\n\nThe dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.\nSpaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.', 1, 3, '0', '2018-04-16 14:11:40');

CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `module` varchar(100) DEFAULT NULL,
  `controller` varchar(100) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `trash` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
