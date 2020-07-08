<?php
session_start();

$database = "../../database/database.db";
$db = new PDO('sqlite:' . $database);
// Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $verify = "update user set mail_verified = 1 WHERE hash= :hash";
    $stmt = $db->prepare($verify);
    // Binde die Parameter an die Variablen,
    $stmt->bindParam(':hash', $token);
    // Und führe die Transaktion letzlich aus.
    $stmt->execute();
    echo "Die Mail wurde erfolgreich bestätigt.";
    unlink('tmp/'.$token.'.txt');
    exit;
} else {
    echo "Kein entsprechender Token vorhanden.";
    exit;
}