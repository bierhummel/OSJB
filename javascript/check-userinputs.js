//JS-Datei zur Kontrolle von verschiedenen User-Inputs


//Funktionen deklarieren:

function check_reg_pw(){
//Prüft ob die beiden PW-Eingaben bei Registrierung gleich sind    
    if( document.getElementById("r_passwort").value != document.getElementById("r_passwort2").value) 
    {
        alert("Achtung: Passwörter stimmen nicht überein");
        return false;
    }
}

function check_plz(){
//Prüft an verschiedenen Stellen, ob eine vom format her korrekte PLZ eingegeben wurde
    if( document.getElementById("plz").value.length != 5 || isNaN(Number(document.getElementById("plz").value) ) ) 
    {
        alert("Achtung: Bitte gültige fünfstellige PLZ eingeben");
        return false;
    }
}

//Eventlistener anhängen:
if (document.getElementById("plz") != null){
    document.getElementById("plz").addEventListener("change", check_plz );
}

/*Klappt nicht..*/
if (document.getElementById("suchen") != null){
    document.getElementById("suchen").addEventListener("submit", check_plz );
}

if (document.getElementById("r_passwort2") != null){
    document.getElementById("r_passwort2").addEventListener("change", check_reg_pw );
}

/*Klappt nicht..*/
if (document.getElementById("registrieren") != null){
    document.getElementById("registrieren").addEventListener("submit", check_reg_pw );
}



        