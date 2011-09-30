CREATE TABLE IF NOT EXISTS `mailer_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL COMMENT 'Код ',
  `name` varchar(200) NOT NULL COMMENT 'Наименование',
  `value` varchar(250) NOT NULL COMMENT 'Значение',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `value` (`value`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

INSERT INTO `mailer_fields` (`id`, `code`, `name`, `value`) VALUES
(1, '{FIRST_NAME}', 'Имя', '$user->first_name'),
(2, '{LAST_NAME}', 'Фамилия', '$user->last_name'),
(3, '{PATRONYMIC}', 'Отчество', '$user->patronymic'),
(5, '{DATE}', 'Текущая дата', 'date(''d.m.Y'')'),
(6, '{ROLE}', 'Наименование группы к которой принадлежит пользователь', '$user->role->description'),
(7, '{APPEAL}', 'Обращение к пользователю', '$user->gender == User::GENDER_MAN ? ''Уважаемый'' : ''Уважаемая''');

CREATE TABLE IF NOT EXISTS `mailer_letters` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned DEFAULT NULL COMMENT 'Шаблон',
  `subject` varchar(150) NOT NULL COMMENT 'Тема письма',
  `text` text NOT NULL COMMENT 'Текст письма',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата отправки',
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `mailer_recipients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `letter_id` int(11) unsigned NOT NULL COMMENT 'Рассылка',
  `user_id` int(11) unsigned NOT NULL COMMENT 'Пользователь',
  `status` enum('accepted','fail','waiting','sent') DEFAULT 'waiting' COMMENT 'Статус',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата отправки',
  PRIMARY KEY (`id`),
  UNIQUE KEY `letter_id_2` (`letter_id`,`user_id`),
  KEY `letter_id` (`letter_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `mailer_templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL COMMENT 'Название',
  `subject` varchar(150) NOT NULL COMMENT 'Тема письма',
  `text` text NOT NULL COMMENT 'Текст письма',
  `is_basic` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Основной',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


CREATE TABLE IF NOT EXISTS `mailer_templates_recipients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `template_id_2` (`template_id`,`user_id`),
  KEY `template_id` (`template_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `settings` (`module_id`, `name`, `code`, `value`) VALUES
('mailer', 'Таймаут отправки (сек.)', 'timeout', '30'),
('mailer', 'Подпись в письме', 'signature', 'Данное сообщение отправлено роботом, просим Вас на него не отвечать.'),
('mailer', 'Кодировка писем', 'encoding', 'KOI8-U'),
('mailer', 'Адрес для ответа', 'reply_address', 'reply@electro-polis.ru'),
('mailer', 'Отправлять писем за раз', 'letters_part_count', '1'),
('mailer', 'Последнее время отправки', 'dispatch_time', '1315352993'),
('mailer', 'Имя от кого', 'from_name', 'Электрополис'),
('mailer', 'Хост', 'host', 'mail.el.korolevsait.ru'),
('mailer', 'Порт', 'port', '25'),
('mailer', 'Логин', 'login', 'elpolis'),
('mailer', 'Пароль', 'password', 'EPdEUoTn');


ALTER TABLE `mailer_letters`
  ADD CONSTRAINT `mailer_letters_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `mailer_templates` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `mailer_recipients`
--
ALTER TABLE `mailer_recipients`
  ADD CONSTRAINT `mailer_recipients_ibfk_1` FOREIGN KEY (`letter_id`) REFERENCES `mailer_letters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mailer_recipients_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `mailer_templates_recipients`
--
ALTER TABLE `mailer_templates_recipients`
  ADD CONSTRAINT `mailer_templates_recipients_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `mailer_templates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mailer_templates_recipients_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
