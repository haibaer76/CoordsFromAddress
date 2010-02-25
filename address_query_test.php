<?php
require_once('PHPUnit/Framework.php');

require_once('address_query.php');

class AddressQuerierTest extends PHPUnit_Framework_TestCase {
	public function testExistingAddressInHamburg() {
		$coords = AddressQuerier::queryCoordinates("Wandsbeker Chaussee", 29, "Hamburg");
		$this->assertNotNull($coords);
		$this->assertEquals($coords->placemark, "Wandsbeker Chaussee 29, Hamburg, Germany");
		$this->assertEquals($coords->lon, 10.037616);
		$this->assertEquals($coords->lat, 53.565632);
	}
}
?>
