Webprogrammierung Sose 2020
Freitagstutorium (Roman) - Gruppe 2

Namen der Studierenden der Gruppe: 
-Alexandra Oswald
-Eike Jan�en

Voraussetzungen:
-php.ini: PDO mit SQLite und fileupload m�ssen erlaubt sein.
-Da kein Admin-Konto vorliegt, spielt es keine Rolle, ob selbsterstelle Nutzerdaten oder die vergebenen Testdaten genutzt werden. Mit der Datei create-SQLiteDB.php wird die DB und die Testdaten neu erstellt, falls die DB gel�scht wird. Hier sind die Login-Daten f�r die Testbenutzer ggf. auslesbar.

Funktionalit�ten:
-Beim Aufruf des Index wird die SQLite-DB sowie ein paar Test-Nutzer und Test-Jobangebote automatisch erstellt, falls keine DB gefunden wurde.
-Nutzer k�nnen ohne Anmeldung nach Eingabe ihrer PLZ und des gew�nschten Umkreises eine Auflistung an Jobangebote abrufen und diese auch einzeln im Detail einsehen.
-Mehrere weitere Filteroptionen verf�gbar und frei kombinierbar.
-Echtzeitsuche nach Jobbezeichnungen mit Vorschl�gen zur automatischen Vervollst�ndigung (AJAX).
-Auf kleinen Bildschirmen werden die Filteroptionen automatisch ausgeblendet, lassen sich aber �ber reinen CSS-Code flexibel ein- und ausblenden.
-Ferner k�nnen Impressum, Datenschutzerkl�rung, Nutzungsbedingungen und eine ��ber uns�-Seite frei aufgerufen werden.
-Arbeitgeber k�nnen sich Registrieren.
-Die Registrierung muss �ber tempor�re .txt-Dateien verifiziert werden, welche das Versenden von E-Mails simulieren sollen.
-Nach Registrierung k�nnen sich Arbeitgeber anmelden und ihr Profil einsehen, wo sie freiwillig weitere Informationen hinterlegen k�nnen, die das Erstellen von Jobangeboten erleichtern k�nnen.
-Damit verbunden ist Einsatz von Sessions (jedoch keine sonstigen Cookies).
-Upload eines Firmenlogos hier ebenfalls m�glich (wir nur bei Jobangeboten angezeigt).
-Au�erdem automatische �bersicht aller erstellen Jobangebote.
-Neue Jobangebote erstellen.
-Arbeitgeber k�nnen einen Link angeben, �ber den sich die Nutzer direkt beim Unternehmen bewerben k�nnen.
-Bestehende Jobangebote bearbeiten und l�schen.
-Die Koordinaten des potenziellen Arbeitsplatzes anhand der gegebenen Adresse und des Suchenden anhand der PLZ werden mithilfe der GoogleMapsAPI bestimmt.
-An mehreren Stellen werden die User-Eingaben zur Laufzeit mittels Javascript �berpr�ft (zus�tzlich zur serverseitigen �berpr�fung).

Umsetzung der Teilaufgaben:
Abgesehen vom Austesten der PDO-Implementierung mit MySQL wurden unseres Wissens alle Teilaufgaben umgesetzt, auch wenn der Einsatz von JavaScript/jQuery und WebServices/APIs leider eher �berschaubar ausgefallen ist und das Design einiger Seiten mit noch etwas mehr Zeit sicherlich noch h�tte verbessert werden k�nnen.

Bekannte Fehler/M�ngel (neben den im letzten Punkt angesprochenen Aspekten):
-Das Erstellen einer neuen DB mit Tabellen und Testdaten erfolgt nur beim Aufruf der Startseite.
-Sind zwei Benutzer mit dem gleichen Profil angemeldet und �ndert einer der beiden die Daten des Profils, bekommt der andere davon nichts mit bis er sich aus- und wieder einloggt.
-Das hochgeladene Firmenlogo ist f�r den Arbeitgeber nicht einsehbar, bis er ein Jobangebot damit erstellt.
-Die Anzahl der angezeigten Jobangebote in der �bersicht der Suchergebnisse oder im Profil des Arbeitgebers wird nicht reguliert.
-Vom Arbeitgeber eingegebene Links funktionieren nicht, wenn der Link nicht genauso wie vorgegeben eingegeben wird.
-Die Handhabung von R�ckmeldungen an den Client (Platzierung und Kennzeichnung), sowie die R�ckmeldungen selbst, sind nicht optimal.
-Verwendung des mousedown-Events bei der Vervollst�ndigung von Jobbezeichnungen in den Filteroptionen nicht optimal, aber click-Event hat zu gr��eren Problemen gef�hrt (Mit Roman besprochen).
-�berpr�fung der User-Eingaben mit JS f�hrt in den meisten F�llen nicht dazu, dass ein Submit verhindert wird, sondern gibt nur eine Meldung aus.
-Viele urspr�nglich geplante Funktionen/Inhalte zeitlich nicht umgesetzt bekommen.
-Anzahl der Testdaten ist sehr �berschaubar.

Besonderheiten:
/
