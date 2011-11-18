CREATE TABLE abonnement (
	`id_u` int(11) NOT NULL,
	`id_f` int(11) NOT NULL,
	`tag` varchar(64) NOT NULL,
	PRIMARY KEY (`id_u`,`id_f`)
)  ENGINE=MyISAM  ;
CREATE TABLE compte (
	`id_u` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`id` varchar(16) NOT NULL,
	`password` varchar(255) NOT NULL,
	`remember` varchar(64) NOT NULL,
	`is_admin` tinyint(1) NOT NULL,
	`date` datetime NOT NULL,
	`nb_abonnement` int(11) NOT NULL,
	`last_login` datetime NOT NULL,
	`nb_publication` int(11) NOT NULL,
	`last_publication` datetime NOT NULL,
	PRIMARY KEY (`id_u`),
	UNIQUE KEY name (`name`),
	UNIQUE KEY id (`id`)
)  ENGINE=MyISAM  ;
CREATE TABLE error (
	`search` varchar(255) NOT NULL,
	`date` datetime NOT NULL,
	`raison` varchar(255) NOT NULL
)  ENGINE=MyISAM  ;
CREATE TABLE feed (
	`id_f` int(11) NOT NULL AUTO_INCREMENT,
	`url` varchar(512) NOT NULL,
	`title` varchar(255) NOT NULL,
	`last_id` varchar(255) NOT NULL,
	`last_maj` datetime NOT NULL,
	`last_recup` datetime NOT NULL,
	`link` varchar(255) NOT NULL,
	`etag` varchar(128) NOT NULL,
	`last-modified` varchar(128) NOT NULL,
	`lasterror` varchar(64) NOT NULL,
	`item_title` varchar(255) NOT NULL,
	`item_link` varchar(255) NOT NULL,
	`item_content` text NOT NULL,
	PRIMARY KEY (`id_f`),
	UNIQUE KEY url (`url`),
	UNIQUE KEY last_recup (`last_recup`,`id_f`),
	KEY last_maj (`last_maj`,`id_f`)
)  ENGINE=MyISAM  ;
CREATE TABLE mur (
	`id_m` int(11) NOT NULL AUTO_INCREMENT,
	`id_u` int(11) NOT NULL,
	`content` text NOT NULL,
	`date` datetime NOT NULL,
	`title` varchar(255) NOT NULL,
	`link` varchar(255) NOT NULL,
	PRIMARY KEY (`id_m`)
)  ENGINE=MyISAM  ;