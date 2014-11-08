<?php
include 'config.php';

function CreateAccesRights(){
	DbConnect();
	$result = mysql_query('SELECT `acces_rights`.`acces_right_id`,
					`acces_rights`.`acces_right_name`
				FROM `dslusarz_baza`.`acces_rights` where `acces_rights`.`acces_right_name` = "admin";') or die(mysql_error());
	if(!$result){
		mysql_query('INSERT INTO acces_rights (acces_right_name) VALUES ("admin")') or die(mysql_error());
	}
	
	$result = mysql_query('SELECT `acces_rights`.`acces_right_id`,
					`acces_rights`.`acces_right_name`
				FROM `dslusarz_baza`.`acces_rights` where `acces_rights`.`acces_right_name` = "activeReader";') or die(mysql_error());
	if(!$result){
		mysql_query('INSERT INTO acces_rights (acces_right_name) VALUES ("activeReader")') or die(mysql_error());
	}
	
	$result = mysql_query('SELECT `acces_rights`.`acces_right_id`,
					`acces_rights`.`acces_right_name`
				FROM `dslusarz_baza`.`acces_rights` where `acces_rights`.`acces_right_name` = "disactiveReader";') or die(mysql_error());
	if(!$result){
		mysql_query('INSERT INTO acces_rights (acces_right_name) VALUES ("disactiveReader")') or die(mysql_error());
	}
	DbClose();
}

function CreateOwner(){
	DbConnect();
	
	$result = mysql_query('SELECT * FROM acces_rights WHERE acces_right_name = "admin";') or die(mysql_error());
	
	if(mysql_num_rows($result) == 0) {
			die('Błąd');
	}
	$row = mysql_fetch_assoc($result);
		
	$result = mysql_query('SELECT `admins`.`admin_login`
							FROM `dslusarz_baza`.`admins` where `admins`.`admin_login` = "dslusarz";') or die(mysql_error());	
	if(!$result){
	mysql_query('INSERT INTO admins 
		   (admin_login, admin_password, admin_email, admin_name, admin_surname, admin_acces_right_id) 
	VALUES ("dslusarz", "'.Codepass('wiosna').'", "slusarz.dominik@gmail.com", "Dominik", "Ślusarz", "'.$row['acces_right_id'].'");') or die(mysql_error());
	}
	DbClose();
}

function CreateDatabase(){
	DbConnect();
	
	mysql_query('CREATE TABLE authors (
	  author_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	  author_name varchar(255) NOT NULL,
	  author_surname varchar(255) NOT NULL,
	  PRIMARY KEY (author_id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;');
	
	mysql_query('CREATE TABLE publisher_houses (
	  publisher_house_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	  publisher_house_name varchar(255) NOT NULL,
	  PRIMARY KEY (publisher_house_id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;');
	
	mysql_query('CREATE TABLE admins (
	  admin_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	  admin_login varchar(255) NOT NULL,
	  admin_password varchar(255) NOT NULL,
	  admin_email varchar(255) NOT NULL,
	  admin_name varchar(255) NOT NULL,
	  admin_surname varchar(255) NOT NULL,
	  admin_access_right_id int(10) NOT NULL,
	  PRIMARY KEY (admin_id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;');
	
	mysql_query('CREATE TABLE readers (
	  reader_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	  reader_login varchar(255) NOT NULL,
	  reader_password varchar(255) NOT NULL,
	  reader_email varchar(255) NOT NULL,
	  reader_name varchar(255) NOT NULL,
	  reader_surname varchar(255) NOT NULL, 
	  reader_address varchar(500) NOT NULL,
	  reader_active_account date NOT NULL,
	  reader_acces_right_id int(10) NOT NULL,
	  PRIMARY KEY (reader_id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;');
	
	mysql_query('CREATE TABLE news (
	  new_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	  new_topic varchar(255) NOT NULL,
	  new_text varchar(3000) NOT NULL,
	  new_date DATETIME NOT NULL,
	  PRIMARY KEY (new_id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;');
	
	mysql_query('CREATE TABLE access_rights (
	  access_right_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	  access_right_name varchar(255) NOT NULL,
	  PRIMARY KEY (access_right_id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;');

	DbClose();
	}
	
	//CreateDatabase();
	CreateAccesRights();
	CreateOwner();
?>