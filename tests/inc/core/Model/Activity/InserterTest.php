<?php

namespace Runalyze\Model\Activity;

use Runalyze\Configuration;
use Runalyze\Model;
use Runalyze\Data\Weather;

use PDO;

/**
 * Generated by hand
 */
class InserterTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var \PDO
	 */
	protected $PDO;

	protected $OutdoorID;
	protected $IndoorID;
	protected $ShoeID1;
	protected $ShoeID2;

	protected function setUp() {
		\Cache::clean();
		$this->PDO = \DB::getInstance();
		$this->PDO->exec('INSERT INTO `'.PREFIX.'sport` (`kcal`,`outside`,`accountid`,`power`) VALUES(600,1,0,1)');
		$this->OutdoorID = $this->PDO->lastInsertId();
		$this->PDO->exec('INSERT INTO `'.PREFIX.'sport` (`kcal`,`outside`,`accountid`,`power`) VALUES(400,0,0,0)');
		$this->IndoorID = $this->PDO->lastInsertId();
		$this->PDO->exec('INSERT INTO `'.PREFIX.'shoe` (`km`,`time`,`accountid`) VALUES(10,3000,0)');
		$this->ShoeID1 = $this->PDO->lastInsertId();
		$this->PDO->exec('INSERT INTO `'.PREFIX.'shoe` (`km`,`time`,`accountid`) VALUES(0,0,0)');
		$this->ShoeID2 = $this->PDO->lastInsertId();

		\SportFactory::reInitAllSports();
		\ShoeFactory::reInitAllShoe();
	}

	protected function tearDown() {
		$this->PDO->exec('TRUNCATE TABLE `'.PREFIX.'training`');
		$this->PDO->exec('TRUNCATE TABLE `'.PREFIX.'sport`');
		$this->PDO->exec('TRUNCATE TABLE `'.PREFIX.'shoe`');
		\Cache::clean();
	}

	/**
	 * @param array $data
	 * @return int
	 */
	protected function insert(array $data) {
		$Inserter = new Inserter($this->PDO, new Object($data));
		$Inserter->setAccountID(0);
		$Inserter->insert();

		return $Inserter->insertedID();
	}

	/**
	 * @param int $id
	 * @return \Runalyze\Model\Activity\Object
	 */
	protected function fetch($id) {
		return new Object(
			$this->PDO->query('SELECT * FROM `'.PREFIX.'training` WHERE `id`="'.$id.'" AND `accountid`=0')->fetch(PDO::FETCH_ASSOC)
		);
	}

	/**
	 * @expectedException \PHPUnit_Framework_Error
	 */
	public function testWrongObject() {
		new Inserter($this->PDO, new Model\Trackdata\Object);
	}

	public function testSimpleInsert() {
		$Object = $this->fetch(
			$this->insert(array(
				Object::TIME_IN_SECONDS => 3600,
				Object::DISTANCE => 12.0
			))
		);

		$this->assertEquals(time(), $Object->get(Object::TIMESTAMP_CREATED), '', 10);
		$this->assertEquals(3600, $Object->duration());
		$this->assertEquals(12.0, $Object->distance());
	}

	public function testOutdoorData() {
		$Object = $this->fetch(
			$this->insert(array(
				Object::TIME_IN_SECONDS => 3600,
				Object::WEATHERID => Weather\Condition::SUNNY,
				Object::TEMPERATURE => 7,
				Object::CLOTHES => array(1,2,3),
				Object::SPORTID => $this->OutdoorID
			))
		);

		$this->assertEquals(Weather\Condition::SUNNY, $Object->weather()->condition()->id());
		$this->assertEquals(7, $Object->weather()->temperature()->value());
		$this->assertFalse($Object->clothes()->isEmpty());
	}

	public function testIndoorData() {
		$Object = $this->fetch(
			$this->insert(array(
				Object::TIME_IN_SECONDS => 3600,
				Object::WEATHERID => Weather\Condition::SUNNY,
				Object::TEMPERATURE => 7,
				Object::CLOTHES => array(1,2,3),
				Object::SPORTID => $this->IndoorID
			))
		);

		$this->assertTrue($Object->weather()->isEmpty());
		$this->assertTrue($Object->clothes()->isEmpty());
	}

	public function testCalories() {
		$ObjectWithout = $this->fetch(
			$this->insert(array(
				Object::TIME_IN_SECONDS => 3600,
				Object::SPORTID => 1
			))
		);

		$this->assertEquals(600, $ObjectWithout->calories());

		$ObjectWith = $this->fetch(
			$this->insert(array(
				Object::TIME_IN_SECONDS => 3600,
				Object::SPORTID => 1,
				Object::CALORIES => 873
			))
		);

		$this->assertEquals(873, $ObjectWith->calories());
	}

	public function testEquipmentUpdate() {
		$this->insert(array(
			Object::TIME_IN_SECONDS => 3600,
			Object::DISTANCE => 12,
			Object::SHOEID => $this->ShoeID1
		));
		$this->insert(array(
			Object::TIME_IN_SECONDS => 3600,
			Object::DISTANCE => 12,
			Object::SHOEID => $this->ShoeID2
		));

		$this->assertEquals(array(
			'km' => 22,
			'time' => 6600
		), $this->PDO->query('SELECT `km`, `time` FROM `'.PREFIX.'shoe` WHERE `id`='.$this->ShoeID1.' AND `accountid`=0')->fetch(PDO::FETCH_ASSOC));
		$this->assertEquals(array(
			'km' => 12,
			'time' => 3600
		), $this->PDO->query('SELECT `km`, `time` FROM `'.PREFIX.'shoe` WHERE `id`='.$this->ShoeID2.' AND `accountid`=0')->fetch(PDO::FETCH_ASSOC));
	}

	public function testStartTimeUpdate() {
		$current = time();
		$timeago = mktime(0,0,0,1,1,2000);

		Configuration::Data()->updateStartTime($current);

		$this->insert(array(
			Object::TIMESTAMP => $current
		));

		$this->assertEquals($current, Configuration::Data()->startTime());

		$this->insert(array(
			Object::TIMESTAMP => $timeago
		));

		$this->assertEquals($timeago, Configuration::Data()->startTime());
	}

	public function testCalculationsForRunning() {
		$Object = $this->fetch( $this->insert(array(
			Object::DISTANCE => 10,
			Object::TIME_IN_SECONDS => 3000,
			Object::HR_AVG => 150,
			Object::SPORTID => Configuration::General()->runningSport()
		)));

		$this->assertGreaterThan(0, $Object->vdotByTime());
		$this->assertGreaterThan(0, $Object->vdotByHeartRate());
		$this->assertGreaterThan(0, $Object->vdotWithElevation());
		$this->assertGreaterThan(0, $Object->jdIntensity());
		$this->assertGreaterThan(0, $Object->trimp());
	}

	public function testCalculationsForNotRunning() {
		$Object = $this->fetch( $this->insert(array(
			Object::DISTANCE => 10,
			Object::TIME_IN_SECONDS => 3000,
			Object::HR_AVG => 150,
			Object::SPORTID => Configuration::General()->runningSport() + 1
		)));

		$this->assertEquals(0, $Object->vdotByTime());
		$this->assertEquals(0, $Object->vdotByHeartRate());
		$this->assertEquals(0, $Object->vdotWithElevation());
		$this->assertEquals(0, $Object->jdIntensity());
		$this->assertGreaterThan(0, $Object->trimp());
	}

	public function testVDOTstatisticsUpdate() {
		$current = time();
		$timeago = mktime(0,0,0,1,1,2000);
		$running = Configuration::General()->runningSport();
		$raceid = Configuration::General()->competitionType();

		Configuration::Data()->updateVdotShape(0);
		Configuration::Data()->updateVdotCorrector(1);

		$this->insert(array(
			Object::TIMESTAMP => $timeago,
			Object::DISTANCE => 10,
			Object::TIME_IN_SECONDS => 30*60,
			Object::HR_AVG => 150,
			Object::SPORTID => $running,
			Object::TYPEID => $raceid + 1,
			Object::USE_VDOT => true
		));
		$this->insert(array(
			Object::TIMESTAMP => $current,
			Object::DISTANCE => 10,
			Object::TIME_IN_SECONDS => 30*60,
			Object::HR_AVG => 150,
			Object::SPORTID => $running + 1,
			Object::USE_VDOT => true
		));
		$this->insert(array(
			Object::TIMESTAMP => $current,
			Object::DISTANCE => 10,
			Object::TIME_IN_SECONDS => 30*60,
			Object::SPORTID => $running,
			Object::USE_VDOT => true
		));

		$this->assertEquals(0, Configuration::Data()->vdotShape());
		$this->assertEquals(1, Configuration::Data()->vdotFactor());

		$this->insert(array(
			Object::TIMESTAMP => $current,
			Object::DISTANCE => 10,
			Object::TIME_IN_SECONDS => 30*60,
			Object::HR_AVG => 150,
			Object::SPORTID => $running,
			Object::TYPEID => $raceid + 1,
			Object::USE_VDOT => true
		));

		$this->assertNotEquals(0, Configuration::Data()->vdotShape());
		$this->assertEquals(1, Configuration::Data()->vdotFactor());

		$this->insert(array(
			Object::TIMESTAMP => $current,
			Object::DISTANCE => 10,
			Object::TIME_IN_SECONDS => 30*60,
			Object::HR_AVG => 150,
			Object::SPORTID => $running,
			Object::TYPEID => $raceid,
			Object::USE_VDOT => true
		));

		$this->assertNotEquals(0, Configuration::Data()->vdotShape());
		$this->assertNotEquals(1, Configuration::Data()->vdotFactor());
	}

	public function testWithCalculationsFromAdditionalObjects() {
		$Activity = new Object(array(
			Object::DISTANCE => 10,
			Object::TIME_IN_SECONDS => 3000,
			Object::HR_AVG => 150,
			Object::SPORTID => Configuration::General()->runningSport()
		));

		$Inserter = new Inserter($this->PDO);
		$Inserter->setAccountID(0);
		$Inserter->insert($Activity);
		$ObjectWithout = $this->fetch( $Inserter->insertedID() );

		$Inserter->setTrackdata(new Model\Trackdata\Object(array(
			Model\Trackdata\Object::TIME => array(1500, 3000),
			Model\Trackdata\Object::HEARTRATE => array(125, 175)
		)));
		$Inserter->setRoute(new Model\Route\Object(array(
			Model\Route\Object::ELEVATION_UP => 500,
			Model\Route\Object::ELEVATION_DOWN => 100
		)));

		$Inserter->insert($Activity);
		$ObjectWith = $this->fetch( $Inserter->insertedID());

		$this->assertGreaterThan($ObjectWithout->vdotWithElevation(), $ObjectWith->vdotWithElevation());
		$this->assertGreaterThan($ObjectWithout->jdIntensity(), $ObjectWith->jdIntensity());
		$this->assertGreaterThan($ObjectWithout->trimp(), $ObjectWith->trimp());
	}

	public function testTemperature() {
		$Zero = $this->fetch(
			$this->insert(array(
				Object::TEMPERATURE => 0
			))
		);

		$this->assertEquals(0, $Zero->weather()->temperature()->value());
		$this->assertFalse($Zero->weather()->temperature()->isUnknown());
		$this->assertFalse($Zero->weather()->isEmpty());
	}

	public function testPowerCalculation() {
		// TODO: Needs configuration setting
		if (Configuration::ActivityForm()->computePower()) {
			$ActivityIndoor = new Object(array(
				Object::DISTANCE => 10,
				Object::TIME_IN_SECONDS => 3000,
				Object::SPORTID => $this->IndoorID
			));

			$Trackdata = new Model\Trackdata\Object(array(
				Model\Trackdata\Object::TIME => array(1500, 3000),
				Model\Trackdata\Object::DISTANCE => array(5, 10)
			));

			$Inserter = new Inserter($this->PDO);
			$Inserter->setAccountID(0);
			$Inserter->setTrackdata($Trackdata);
			$Inserter->insert($ActivityIndoor);

			$this->assertEquals(0, $this->fetch($Inserter->insertedID())->power());

			$ActivityOutdoor = clone $ActivityIndoor;
			$ActivityOutdoor->set(Object::SPORTID, $this->OutdoorID);
			$Inserter->insert($ActivityOutdoor);

			$this->assertNotEquals(0, $this->fetch($Inserter->insertedID())->power());
			$this->assertNotEmpty($Trackdata->power());
		}
	}

}
