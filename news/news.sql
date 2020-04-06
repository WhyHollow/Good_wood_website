CREATE TABLE news (
  id_news int(11) NOT NULL auto_increment,
  name tinytext NOT NULL,
  body text NOT NULL,
  putdate datetime NOT NULL default '0000-00-00 00:00:00',
  url tinytext NOT NULL,
  url_text tinytext NOT NULL,
  url_pict tinytext NOT NULL,
  hide enum('show','hide') NOT NULL default 'show',
  PRIMARY KEY  (id_news)
) TYPE=MyISAM;
INSERT INTO news VALUES (1, 'Первая новость', 'Заработала система новостей.', '2004-06-24 23:39:06', 'http://www.softtime.ru', 'поддержка', '', 'show');
