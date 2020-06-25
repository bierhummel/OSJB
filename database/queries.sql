-- SKRIPT NUR FUER INTERNE QUERY-ERSTELLUNG

--  WICHTIG: SQLite3 Einstellungen: 
-- .nullvalue 'NULL'
-- .headers on

-- Tabellen kreieren und Referenzen bilden

create table user (id integer primary key, uname text NOT NULL, vname text NOT NULL, nname text NOT NULL, password text NOT NULL, mail text NOT NULL, strasse text, hausnr text, plz text, stadt text, verified integer NOT NULL, mail_verified integer NOT NULL);

create table if not exists jobangebot (id integer primary key, user_id integer, status integer NOT NULL, titel text, strasse text, hausnr text, plz text, stadt text, beschreibung text, art text, zeitintensitaet text, im_bachelor integer NOT NULL, bachelor integer NOT NULL, im_master integer NOT NULL, master integer NOT NULL, ausbildung integer NOT NULL, fachrichtung text, logo blob, link text, beschaeftigungsbeginn text, alter INTEGER, FOREIGN KEY (user_id) REFERENCES user(id)
select password from user where mail = ":email1";

insert into user (uname, vname, nname, password, mail, strasse, hausnr, plz) values (:uname, :vname, :nname, :password, :mail, :hausnr, :plz);

insert into jobangebot (user_id, status, titel, strasse, hausnr, plz, beschreibung, art, im_bachelor, bachelor, im_master, master, ausbildung, fachrichtung, link, beschaeftigungsbeginn) values (1, :status, :titel, :strasse, :hausnr, :plz, :beschreibung, :art, :im_bachelor, :bachelor, :im_master, :ausbildung, :fachrichtung, :link, :beschaeftigungsbeginn)