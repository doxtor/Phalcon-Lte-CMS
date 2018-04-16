CREATE TABLE IF NOT EXISTS `logger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for log';

CREATE TABLE `acl` (
  `id` int(11) NOT NULL,
  `controller` char(15) NOT NULL,
  `action` char(15) NOT NULL,
  PRIMARY KEY (`id`,`controller`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for ACL';


CREATE TABLE `modules` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'идентификатор',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT 'название',
  `site` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'используется на сайте: 0 - нет, 1 - да',
  `admin` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'используется в административной части: 0 - нет, 1 - да',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT 'название для пользователей',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='Модули';

INSERT INTO `modules` (`id`, `name`, `site`, `admin`, `title`) VALUES
(1, 'admin', '0', '1', 'Админ'),
(2, 'content', '1', '1', 'Контент'),
(3, 'users', '1', '1', 'Пользователи');

CREATE TABLE `site` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'идентификатор',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'идентификатор родителя из таблицы `site`',
  `count_children` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'количество вложенных страниц',
  `name1` varchar(100) NOT NULL DEFAULT '' COMMENT 'название',
  `title_meta1` varchar(250) NOT NULL DEFAULT '' COMMENT 'заголовок окна в браузере, тег Title',
  `keywords1` varchar(250) NOT NULL DEFAULT '' COMMENT 'ключевые слова, тег Keywords',
  `descr1` text COMMENT 'описание, тэг Description',
  `canonical1` varchar(100) NOT NULL DEFAULT '' COMMENT 'канонический тег',
  `text1` longtext COMMENT 'контент',
  `act1` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'показывать на сайте: 0 - нет, 1 - да',
  `access` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'доступ ограничен: 0 - нет, 1 - да',
  `date_start` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'дата начала показа',
  `date_finish` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'дата окончания показа',
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'пользователь из таблицы `users`, добавивший или первый отредктировавший страницу в административной части',
  `title_no_show` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'не копировать заголовок в H1: 0 - нет, 1 - да',
  `map_no_show` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'не показывать на карте сайта: 0 - нет, 1 - да',
  `changefreq` enum('always','hourly','daily','weekly','monthly','yearly','never') NOT NULL DEFAULT 'always' COMMENT 'Changefreq для sitemap.xml',
  `priority` varchar(3) NOT NULL DEFAULT '' COMMENT 'Priority для sitemap.xml',
  `noindex` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'не индексировать: 0 - нет, 1 - да',
  `search_no_show` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'не участвует в поисковой выдаче: 0 - нет, 1 - да',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'подрядковый номер для сортировки',
  `timeedit` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'время последнего изменения в формате UNIXTIME',
  `theme` varchar(50) NOT NULL DEFAULT '' COMMENT 'шаблон страницы сайта',
  `module_name` varchar(50) NOT NULL DEFAULT '' COMMENT 'прикрепленный модуль',
  `js` text COMMENT 'JS-код',
  `trash` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'запись удалена в корзину: 0 - нет, 1 - да',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8 COMMENT='Страницы сайта';

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'идентификатор',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT 'логин',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT 'пароль в зашифрованном виде',
  `mail` varchar(64) NOT NULL DEFAULT '' COMMENT 'e-mail',
  `phone` varchar(64) NOT NULL DEFAULT '' COMMENT 'телефон',
  `created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'дата регистрации',
  `fio` varchar(255) NOT NULL DEFAULT '' COMMENT 'ФИО',
  `role_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'идентификатор типа пользователя из таблицы `users_role`',
  `act` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'активен на сайте: 0 - нет, 1 - да',
  `htmleditor` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'использовать визуальный редактор: 0 - нет, 1 - да',
  `copy_files` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'cохранять картинки с внешних сайтов, при вставке контента в визуальный редактор: 0 - нет, 1 - да',
  `useradmin` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT 'панель быстрого редактирования: 0 - отключена, 1 - включена, 2 - только панель без режима редактирования',
  `start_admin` varchar(30) NOT NULL DEFAULT '' COMMENT 'стартовая страница административной части',
  `lang_id` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'идентификатор языка сайта из таблицы `diafan_languages`',
  `admin_nastr` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'колечество элементов на странице в административной части',
  `identity` varchar(255) NOT NULL DEFAULT '' COMMENT 'URL на страницу в соц. сети',
  `config` text COMMENT 'Настройки пользователя',
  `trash` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'запись удалена в корзину: 0 - нет, 1 - да',
  PRIMARY KEY (`id`),
  KEY `name` (`name`(1))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Пользователи';
