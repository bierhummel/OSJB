<?php
//Datei, die Funktionen für include bereitstellt zum den Zugriff auf die Google-Maps-API


//MapsAPIKey setzen
const MAPS_API_KEY = 'AIzaSyCf0GyggZoCCwCRehIR0DLoPcZz5BDtR1c';

//
function getJobsNearby( $radius, $plz, $filtered_jobs ) {
    //Koordinaten der vom User eingegebenen PLZ (Mode 0) bestimmen
    $coordinates = getCoordinates ( $plz, 0 );
    
    if ( $coordinates != null) {

        //Index mitzählen, um einzelnen Eintrag entfernen zu können
        $index = 0;
        //Übergebene vorgefilterte Jobangebote durchlaufen
        foreach ( $filtered_jobs as $row ) {

            //Für jedes Jobangebot die Entfernung berechnen
            $job_coordinates = array( 'lat' => $row['geo_lat'], 'lon' => $row['geo_lon'] );
            $distance = calculateDistance( $coordinates, $job_coordinates );
            
            //Wenn Entfernung größer als der angegebene Radius wird Jobangebot entfernt
            if ( intval($distance) > intval($radius) ) {
                unset($filtered_jobs[$index]);
            }

            $index++;
        }
    }
    else {
        //Fehlermeldung ausgeben?
    }
    
    return $filtered_jobs;
}


// Gibt Koordinaten einer PLZ (Mode = 0) oder Adressse (Mode = 1) zurück
function getCoordinates( $place, $mode ) {
    //Wenn Mode = 0: Es wird eine PLZ von einer User-Suchanfrage übergeben
    if ( $mode == 0 ) {
        $plz = $place;

        $geo_address = urlencode( $plz );
        $request_url = 'https://maps.googleapis.com/maps/api/geocode/xml?address=Deutschland+'.$plz.'+CA&key='.MAPS_API_KEY;
    }
    
    //Wenn Mode = 1: Es wird ein Jobangebot mit Adresse übergeben
    if ( $mode == 1 ) {
        $strasse = $place['job_strasse'];
        $hausnr = $place['job_hausnr'];
        $plz = $place['job_plz'];
        $stadt = $place['job_stadt'];
        $request_url = 'https://maps.googleapis.com/maps/api/geocode/xml?address=Deutschland+'.$strasse. '+'.$hausnr.'+'.$plz.'+'.$stadt.'+CA&key='.MAPS_API_KEY;
    }

    //Request an API losschicken
    $xml =  simplexml_load_file( $request_url ) or die ( 'url not loading' );
    $status = $xml->status;

    if ( $status == 'OK' ) {
        $lat = $xml->result->geometry->location->lat;
        $lon = $xml->result->geometry->location->lng;

        $coordinates = array( 'lat' => $lat, 'lon' => $lon );

        return $coordinates;
    }
}

//Berechnet die Distanz zwischen zwei Geo-Koordinaten
function calculateDistance ( $geo_data1, $geo_data2 ) {

    $lat1 =  floatval( $geo_data1['lat'] );
    $lon1 =  floatval( $geo_data1['lon'] );

    $lat2 =  floatval( $geo_data2['lat'] );
    $lon2 =  floatval( $geo_data2['lon'] );

    // Es wird die Haversine Formel genutzt, um die Distanz zu berechnen:
    $theta = $lon1 - $lon2;
    $dist = sin( deg2rad( $lat1 ) ) * sin( deg2rad( $lat2 ) ) +  cos( deg2rad( $lat1 ) ) * cos( deg2rad( $lat2 ) ) * cos( deg2rad( $theta ) );
    $dist = acos( $dist );
    $dist = rad2deg( $dist );
    $miles = $dist * 60 * 1.1515;
    // Die Formel gibt Meilen zurück, daher wird es in km umgewandelt:
    $distance = ( $miles * 1.609344 );
    return $distance;
}

?>
