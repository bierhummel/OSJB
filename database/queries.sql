-- SKRIPT NUR STARTEN, WENN DB KORRUPT BZW. VERSEHENTLICH GELOESCHT

--  WICHTIG: SQLite3 Einstellungen: 
-- .nullvalue 'NULL'
-- .headers on

-- Tabellen kreieren und Referenzen bilden

create table user (id integer primary key, uname text NOT NULL, vname text NOT NULL, nname text NOT NULL, password text NOT NULL, mail text NOT NULL, strasse text, hausnr text, plz text, verified integer NOT NULL, mail_verified integer NOT NULL);

create table jobangebot (id integer primary key, user_id integer, status integer NOT NULL, titel text, strasse text, hausnr text, plz text, beschreibung text, art text, im_bachelor integer NOT NULL, bachelor integer NOT NULL, im_master integer NOT NULL, master integer NOT NULL, ausbildung integer NOT NULL, fachrichtung text, logo blob, link text, beschaeftigungsbeginn text, FOREIGN KEY (user_id) REFERENCES user(id));

select password from user where mail = ":email1";
