<?php
require_once('PHPUnit/Framework.php');

require_once('address_query.php');

class AddressQuerierTest extends PHPUnit_Framework_TestCase {
	public function testExistingAddressInHamburg() {
		$coords = AddressQuerier::queryCoordinates("Wandsbeker Chaussee", 29, "Hamburg");
		$this->checkCoords($coords, "Wandsbeker Chaussee 29, Hamburg, Germany", 53, 10);
	}

	public function testMyAddressInDresden() {
		$coords = AddressQuerier::queryCoordinates("Bräuergasse", 11, "Dresden");
		$this->checkCoords($coords, "Bräuergasse 11, Dresden, Germany", 51, 13);
	}
	public function testNullAddress() {
		$coords = AddressQuerier::queryCoordinates("This Address", 8, "Should not exist");
		$this->assertNull($coords);
	}

	private function checkCoords($coords, $name, $lat, $lon) {
		$this->assertNotNull($coords);
		$this->assertEquals($coords->placemark, $name);
		$this->assertEquals(floor($coords->lat), $lat);
		$this->assertEquals(floor($coords->lon), $lon);
	}
}
?>
