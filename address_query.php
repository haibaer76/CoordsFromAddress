<?php
/**
 * Return class for the address
 */
class AddressQueryReturn {
	private $placemark;
	private $lat;
	private $lon;
	public function __construct($placemark, $lat, $lon) {
		$this->placemark = $placemark;
		$this->lat = $lat;
		$this->lon = $lon;
	}

	public function __get($name) {
		return $this->$name;
	}
}

class AddressQuerier {

	/**
	 * Does the query and returns the coordinates
	 */
	public static function queryCoordinates($street, $street_number, $city) {
		$query = "$street $street_number, $city, Deutschland";
		$xml = simplexml_load_file("http://maps.google.com/maps?q=".rawurlencode($query)."&output=kml");
		if (!$xml) {
			return null;
		}
		if (!$xml->Placemark || !$xml->Placemark->LookAt) {
			if ($xml->Folder) {
				$pn = (string)($xml->Folder->Placemark->name);
			} else {
				$pn = (string)($xml->Placemark->name);
			}
			if (preg_match("/<a href=\"(.+?)\">/", $pn, $matches)) {
				$xml = simplexml_load_file($matches[1]);
				if (!$xml)
					return null;
			}
		}
		if ($xml->Placemark) {
			return new AddressQueryReturn(
				(string)$xml->Placemark->name,
				floatval($xml->Placemark->LookAt->latitude),
				floatval($xml->Placemark->LookAt->longitude));
		}
		return null;
	}
}
?>
