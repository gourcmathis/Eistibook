CREATE TABLE publication (
	id int(6) NOT NULL auto_increment,
	auteur VARCHAR(30) NOT NULL,
	titre text NOT NULL,
	date datetime NOT NULL default '0000-00-00 00:00:00',
	texte_news text NOT NULL,
	PRIMARY KEY  (id)
) 