<?php


	class googleHelper {
	 	
	 	private $mapApiKey;
	 

		public function __construct($mapApiKey = '') {
		 	if ($mapApiKey){
				$this->mapApiKey;
			} else {
			 	throw new Exception(__CLASS__ . ' error : Kein API-Key vornhanden.');
			}
		}
		

		private function getURL($url){
		 	$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			$tmp = curl_exec($ch);
			curl_close($ch);
			if ($tmp != false){
			 	return $tmp;
			}
		}
		

		public function getCoordinates($address){
			$address = str_replace(' ','+',$address);
		 	$url = 'http://maps.google.com/maps/geo?q=' . $address . '&output=xml&key=' . $this->mapApiKey;
		 	$data = $this->getURL($url);
			if ($data){
				$xml = new SimpleXMLElement($data);
				$requestCode = $xml->Response->Status->code;
				if ($requestCode == 200){
				 	//all is ok
				 	$coords = $xml->Response->Placemark->Point->coordinates;
				 	$coords = explode(',',$coords);
				 	if (count($coords) > 1){
				 		if (count($coords) == 3){
						 	return array('lat' => $coords[1], 'long' => $coords[0], 'alt' => $coords[2]);
						} else {
						 	return array('lat' => $coords[1], 'long' => $coords[0], 'alt' => 0);
						}
					}
				}
			}
			//return default data
			return array('lat' => 0, 'long' => 0, 'alt' => 0);
		}
		

	}; 
?>