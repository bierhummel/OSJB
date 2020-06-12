<?php
    // Passwort von User z.B. Loginformular
    $password = "SicheresPasswort12345";
 
    // Passwort-Hash aus der Datenbank
    $passwortHash = "$2y$10$1GouW6JnUaJV1X8YrsX1munpOKYK7.uDG/y1Ck3B4C0i44OY10ZGa";
 
    // Passwort überprüfen
    if (password_verify($password, $passwortHash)) {
        echo "Passwort stimmt";
    } else {
        echo "Passwort falsch";
    }
?>