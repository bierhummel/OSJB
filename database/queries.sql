-- SKRIPT NUR STARTEN, WENN DB KORRUPT BZW. VERSEHENTLICH GELOESCHT

--  WICHTIG: SQLite3 Einstellungen: 
-- .nullvalue 'NULL'
-- .headers on

-- Tabellen kreieren und Referenzen bilden

create table user (id integer primary key, uname text NOT NULL, vname text NOT NULL, nname text NOT NULL, password text NOT NULL, mail text NOT NULL, strasse text, hausnr text, stadt text, plz text, logo blob, verified integer NOT NULL, mail_verified integer NOT NULL);

create table jobangebot (id integer primary key, user_id integer, status integer NOT NULL, titel text, strasse text, hausnr text, plz text, beschreibung text, art text, im_bachelor integer NOT NULL, bachelor integer NOT NULL, im_master integer NOT NULL, master integer NOT NULL, ausbildung integer NOT NULL, fachrichtung text, link text, beschaeftigungsbeginn text, FOREIGN KEY (user_id) REFERENCES user(id));

select password from user where mail = ":email1";

insert into user (uname, vname, password, mail) values (test, test, test12345, asfasd@dfssfad.de)

update user set uname = ':uname',  vname = 'vorname', nname = ':nachname', password = ':password', mail = ':newMail', strasse = 'strasse', hausnr = 'hausnr', plz= ':plz',  logo = ':logo' where mail = ':oldMail';