-- SKRIPT NUR STARTEN, WENN DB KORRUPT BZW. VERSEHENTLICH GELOESCHT

--  WICHTIG: SQLite3 Einstellungen: 
-- .nullvalue 'NULL'
-- .headers on

-- Tabellen kreieren und Referenzen bilden

create table user (id integer primary key, vname text NOT NULL, nname text NOT NULL, password text NOT NULL, mail text NOT NULL, uname text, strasse text, hausnr text, plz text, verified integer NOT NULL, mail_verified integer NOT NULL);
create table jobangebot (id integer primary key, user_id integer, status integer NOT NULL, titel text, strasse text, hausnr text, plz text, beschreibung text, FOREIGN KEY (user_id) REFERENCES users(id));
create table jobangebot_details (id integer primary key, jobangebot_id integer, art text, im_bachelor integer NOT NULL, bachelor integer NOT NULL, im_master integer NOT NULL, master integer NOT NULL, ausbildung integer NOT NULL, FOREIGN KEY (jobangebot_id) REFERENCES jobangebot(id));

-- Testuser und Jobangebot erstellen
insert into user (nname, vname, password, mail, verified, mail_verified) VALUES ('test','test','12345678','test@gmail.com',0,0);
insert into jobangebot (user_id, status) VALUES (1,0);
insert into jobangebot_details (jobangebot_id, im_bachelor, im_master, bachelor, master, ausbildung) VALUES (1,0,0,0,0,0);

select * from user;
--OUTPUT:
--id|vname|nname|password|mail|uname|strasse|hausnr|plz|verified|mail_verified
--1|test|test|12345678|test@gmail.com|NULL|NULL|NULL|NULL|0|0

select * from jobangebot;
--OUTPUT:
--id|user_id|status|titel|strasse|hausnr|plz|beschreibung
--1|1|0|NULL|NULL|NULL|NULL|NULL

select * from jobangebot_details;
--OUTPUT:
--id|jobangebot_id|art|im_bachelor|bachelor|im_master|master|ausbildung
--1|1|NULL|0|0|0|0|0