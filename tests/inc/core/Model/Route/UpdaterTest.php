<?php

namespace Runalyze\Model\Route;

use PDO;

/**
 * Generated by hand
 */
class UpdaterTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var \PDO
	 */
	protected $PDO;

	protected function setUp() {
		$this->PDO = new PDO('sqlite::memory:');
		$this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->PDO->exec('CREATE TABLE IF NOT EXISTS `'.PREFIX.'route` (
			`id` INTEGER PRIMARY KEY AUTOINCREMENT,
			`accountid` INT NOT NULL,
			`name` VARCHAR( 255 ) NOT NULL,
			`cities` VARCHAR( 255 ) NOT NULL,
			`distance` DECIMAL( 6, 2 ) NOT NULL,
			`elevation` SMALLINT NOT NULL,
			`elevation_up` SMALLINT NOT NULL,
			`elevation_down` SMALLINT NOT NULL,
			`lats` LONGTEXT NOT NULL,
			`lngs` LONGTEXT NOT NULL,
			`elevations_original` LONGTEXT NOT NULL,
			`elevations_corrected` LONGTEXT NOT NULL,
			`elevations_source` VARCHAR( 255 ) NOT NULL,
			`startpoint_lat` FLOAT( 8, 5 ) NOT NULL,
			`startpoint_lng` FLOAT( 8,  5 ) NOT NULL,
			`endpoint_lat` FLOAT( 8, 5 ) NOT NULL,
			`endpoint_lng` FLOAT( 8, 5 ) NOT NULL,
			`min_lat` FLOAT( 8, 5 ) NOT NULL,
			`min_lng` FLOAT( 8, 5 ) NOT NULL,
			`max_lat` FLOAT( 8, 5 ) NOT NULL,
			`max_lng` FLOAT( 8, 5 ) NOT NULL,
			`in_routenet` TINYINT( 1 ) NOT NULL
			);
		');
	}

	protected function tearDown() {
		$this->PDO->exec('DROP TABLE `'.PREFIX.'route`');
	}

	public function testSimpleUpdate() {
		$Inserter = new Inserter($this->PDO);
		$Inserter->setAccountID(1);
		$Inserter->insert(new Object(array(
			Object::NAME => 'Route name',
			Object::DISTANCE => 3.14
		)));

		$Route = new Object($this->PDO->query('SELECT * FROM `'.PREFIX.'route` WHERE `id`='.$Inserter->insertedID())->fetch(PDO::FETCH_ASSOC));
		$Route->set(Object::DISTANCE, 0);

		$Changed = clone $Route;
		$Changed->set(Object::NAME, 'New route name');

		$Updater = new Updater($this->PDO, $Changed, $Route);
		$Updater->setAccountID(1);
		$Updater->update();

		$Result = new Object($this->PDO->query('SELECT * FROM `'.PREFIX.'route` WHERE `id`='.$Inserter->insertedID())->fetch(PDO::FETCH_ASSOC));
		$this->assertEquals('New route name', $Result->name());
		$this->assertEquals(3.14, $Result->distance());
	}

}
