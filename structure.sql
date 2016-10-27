CREATE TABLE IF NOT EXISTS 'brutes_v2' (
	'id' smallint(5) unsigned NoT NULL AUTO_INCREMENT,
	'name' varchar(50) COLLATE utf__general_ci NOT NULL,
	'life' tinyint(3) unsigned NOT NULL DEFAULT '100',
	'strenght' tinyint(3) unsigned NOT NULL DEFAULT '1',
	'xp' tinyint(3) unsigned NOT NULL DEFAULT '0',
	'time_asleep' int(10) unsigned NOT NULL DEFAULTT '0',
	'type' enum('wizard', 'warrior') COLLATE utf8_general_ci NOT NULL,
	'asset' tinyint(3) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY ('id')
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
