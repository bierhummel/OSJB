Webprogrammierung Sose 2020
Freitagstutorium (Roman) - Gruppe 2

Namen der Studierenden der Gruppe: 
-Alexandra Oswald
-Eike Janßen

Voraussetzungen:
-php.ini: PDO mit SQLite und fileupload müssen erlaubt sein.
-Da kein Admin-Konto vorliegt, spielt es keine Rolle, ob selbsterstelle Nutzerdaten oder die vergebenen Testdaten genutzt werden. Mit der Datei create-SQLiteDB.php wird die DB und die Testdaten neu erstellt, falls die DB gelöscht wird. Hier sind die Login-Daten für die Testbenutzer ggf. auslesbar.

Funktionalitäten:
-Beim Aufruf des Index wird die SQLite-DB sowie ein paar Test-Nutzer und Test-Jobangebote automatisch erstellt, falls keine DB gefunden wurde.
-Nutzer können ohne Anmeldung nach Eingabe ihrer PLZ und des gewünschten Umkreises eine Auflistung an Jobangebote abrufen und diese auch einzeln im Detail einsehen.
-Mehrere weitere Filteroptionen verfügbar und frei kombinierbar.
-Echtzeitsuche nach Jobbezeichnungen mit Vorschlägen zur automatischen Vervollständigung (AJAX).
-Auf kleinen Bildschirmen werden die Filteroptionen automatisch ausgeblendet, lassen sich aber über reinen CSS-Code flexibel ein- und ausblenden.
-Ferner können Impressum, Datenschutzerklärung, Nutzungsbedingungen und eine „Über uns“-Seite frei aufgerufen werden.
-Arbeitgeber können sich Registrieren.
-Die Registrierung muss über temporäre .txt-Dateien verifiziert werden, welche das Versenden von E-Mails simulieren sollen.
-Nach Registrierung können sich Arbeitgeber anmelden und ihr Profil einsehen, wo sie freiwillig weitere Informationen hinterlegen können, die das Erstellen von Jobangeboten erleichtern können.
-Damit verbunden ist Einsatz von Sessions (jedoch keine sonstigen Cookies).
-Upload eines Firmenlogos hier ebenfalls möglich (wir nur bei Jobangeboten angezeigt).
-Außerdem automatische Übersicht aller erstellen Jobangebote.
-Neue Jobangebote erstellen.
-Arbeitgeber können einen Link angeben, über den sich die Nutzer direkt beim Unternehmen bewerben können.
-Bestehende Jobangebote bearbeiten und löschen.
-Die Koordinaten des potenziellen Arbeitsplatzes anhand der gegebenen Adresse und des Suchenden anhand der PLZ werden mithilfe der GoogleMapsAPI bestimmt.
-An mehreren Stellen werden die User-Eingaben zur Laufzeit mittels Javascript überprüft (zusätzlich zur serverseitigen Überprüfung).

Umsetzung der Teilaufgaben:
Abgesehen vom Austesten der PDO-Implementierung mit MySQL wurden unseres Wissens alle Teilaufgaben umgesetzt, auch wenn der Einsatz von JavaScript/jQuery und WebServices/APIs leider eher überschaubar ausgefallen ist und das Design einiger Seiten mit noch etwas mehr Zeit sicherlich noch hätte verbessert werden können.

Bekannte Fehler/Mängel (neben den im letzten Punkt angesprochenen Aspekten):
-Das Erstellen einer neuen DB mit Tabellen und Testdaten erfolgt nur beim Aufruf der Startseite.
-Sind zwei Benutzer mit dem gleichen Profil angemeldet und ändert einer der beiden die Daten des Profils, bekommt der andere davon nichts mit bis er sich aus- und wieder einloggt.
-Das hochgeladene Firmenlogo ist für den Arbeitgeber nicht einsehbar, bis er ein Jobangebot damit erstellt.
-Die Anzahl der angezeigten Jobangebote in der Übersicht der Suchergebnisse oder im Profil des Arbeitgebers wird nicht reguliert.
-Vom Arbeitgeber eingegebene Links funktionieren nicht, wenn der Link nicht genauso wie vorgegeben eingegeben wird.
-Die Handhabung von Rückmeldungen an den Client (Platzierung und Kennzeichnung), sowie die Rückmeldungen selbst, sind nicht optimal.
-Verwendung des mousedown-Events bei der Vervollständigung von Jobbezeichnungen in den Filteroptionen nicht optimal, aber click-Event hat zu größeren Problemen geführt (Mit Roman besprochen).
-Überprüfung der User-Eingaben mit JS führt in den meisten Fällen nicht dazu, dass ein Submit verhindert wird, sondern gibt nur eine Meldung aus.
-Viele ursprünglich geplante Funktionen/Inhalte zeitlich nicht umgesetzt bekommen.
-Anzahl der Testdaten ist sehr überschaubar.

Besonderheiten:
/
