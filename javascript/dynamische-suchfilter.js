//Automatische Anzeigen von Suchergebnissen zur Laufzeit beim Eingeben einer Jobbezeichnung als Vorschläge zur automaitschen Vervollständigung mithilfe von AJAX


//Funktion für onclick-Event für die Suchvorschläge
function nutze_vorschlag(vorschlag){
    document.getElementById("bez").value = vorschlag;   //Setze Wert des Textfelds auf den Vorschlag
    document.filter.submit();                           //automatischer Submit
}


//Funktion zum Abfragen von Suchergebnissen beim Eingeben in Textfeld mit AJAX
function suche_jobbez(input){
    if(input == ""){                                    //Wenn Textfeld leer: Zeige keine Vorschläge
        document.getElementById("tipps").innerHTML = "";
        return;                                         //Und beende Funktion
    }
    
    var xmlhttp = new XMLHttpRequest();                 //Sonst XMLHttpRequest-Objekt erstellen
    xmlhttp.onreadystatechange = function() {           //Funktion für Ablauf nach Antwort
        if (this.readyState == 4 && this.status == 200) //Status prüfen (sonst passiert nichts)
        {   
            //Vorschläge ausgeben
            document.getElementById("tipps").innerHTML = this.responseText;
            
            //Eventlistener an jeden Vorschlag anhängen
            //zeigt Fehler, funktioniert aber.. nach Vorlage von https://stackoverflow.com/questions/42080365/using-addeventlistener-and-getelementsbyclassname-to-pass-an-element-id
            var vorschläge = document.getElementsByClassName("vorschlag"); //Vorschläge selectieren
            for(let i = 0; i < vorschläge.length; i++) {       
              vorschläge[i].addEventListener("click", function(){ 
                  nutze_vorschlag(vorschläge[i].innerHTML);
              })
            }
        }
    };
    
    //GET-Request vorbereiten und senden
    xmlhttp.open("GET", "php/process-jobDAO.php?suche=jobbez&input=" + encodeURIComponent(input), true);
    xmlhttp.send();
}

//keyup-Eventlistener an Textfeld anhängen
document.getElementById("bez").addEventListener("keyup", function()
    {
        suche_jobbez(document.getElementById("bez").value); 
    } 
);
//click-Eventlistener an Textfeld anhängen
document.getElementById("bez").addEventListener("click", function()
    { 
        suche_jobbez(document.getElementById("bez").value); 
    } 
);