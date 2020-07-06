//Automatische Anzeigen von Suchergebnissen zur Laufzeit beim Eingeben einer Jobbezeichnung als Vorschläge zur automaitschen Vervollständigung mithilfe von AJAX

function suche_jobbez(input){
    if(input == ""){
        document.getElementById("tipps").innerHTML = "";
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tipps").innerHTML = this.responseText;
        }
    };
    
    xmlhttp.open("GET", "php/calc-job.php?suche=jobbez&input=" + encodeURIComponent(input), true);
    xmlhttp.send();
}


document.getElementById("bez").addEventListener("keyup", function(){ suche_jobbez(document.getElementById("bez").value); } );
