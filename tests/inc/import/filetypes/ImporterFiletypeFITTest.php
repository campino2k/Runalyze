<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2014-04-01 at 17:25:06.
 */
class ImporterFiletypeFITTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var ImporterFiletypeFIT
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->object = new ImporterFiletypeFIT;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {
	}

	/**
	 * @expectedException RuntimeException
	 */
	public function test_nonexistingFile() {
		if (Shell::isPerlAvailable()) {
			$this->object->parseFile('idontexist.fit');
		}
	}

	/**
	 * Test: standard file
	 * Filename: "Standard.fit" 
	 */
	public function test_generalFile() {
		if (Shell::isPerlAvailable()) {
			$this->object->parseFile('../tests/testfiles/fit/Standard.fit');

			$this->assertFalse( $this->object->hasMultipleTrainings() );
			$this->assertFalse( $this->object->failed() );

			$this->assertEquals( 0*3600 + 53*60 + 06, $this->object->object()->getTimeInSeconds(), '', 30);
			$this->assertEquals( 1*3600 + 00*60 + 53, $this->object->object()->getElapsedTime() );
			$this->assertTrue( $this->object->object()->hasElapsedTime() );

			$this->assertEquals( 8.98, $this->object->object()->getDistance(), '', 0.1);
			$this->assertEquals( 305, $this->object->object()->getCalories(), '', 10);
			$this->assertEquals( 123, $this->object->object()->getPulseAvg(), '', 2);
			$this->assertEquals( 146, $this->object->object()->getPulseMax(), '', 2);
			$this->assertTrue( $this->object->object()->hasArrayAltitude() );
			$this->assertTrue( $this->object->object()->hasArrayDistance() );
			$this->assertTrue( $this->object->object()->hasArrayHeartrate() );
			$this->assertTrue( $this->object->object()->hasArrayLatitude() );
			$this->assertTrue( $this->object->object()->hasArrayLongitude() );
			$this->assertTrue( $this->object->object()->hasArrayPace() );
			$this->assertTrue( $this->object->object()->hasArrayTime() );
			$this->assertFalse( $this->object->object()->hasArrayGroundContact() );
			$this->assertFalse( $this->object->object()->hasArrayVerticalOscillation() );

			$this->assertEquals( 1, $this->object->object()->Sport()->id() );

			$this->assertFalse( $this->object->object()->Splits()->areEmpty() );
		}
	}

	/**
	 * Test: fenix file
	 * Filename: "Fenix-2.fit" 
	 */
	public function test_FenixFile() {
		if (Shell::isPerlAvailable()) {
			$this->object->parseFile('../tests/testfiles/fit/Fenix-2.fit');

			$this->assertFalse( $this->object->hasMultipleTrainings() );
			$this->assertFalse( $this->object->failed() );

			$this->assertEquals( 16*60 + 15, $this->object->object()->getTimeInSeconds() );
			$this->assertEquals( 20*60 + 10, $this->object->object()->getElapsedTime() );
			$this->assertTrue( $this->object->object()->hasElapsedTime() );

			$this->assertEquals( 2.94, $this->object->object()->getDistance(), '', 0.1);
			$this->assertEquals( 159, $this->object->object()->getCalories(), '', 10);
			$this->assertEquals( 137, $this->object->object()->getPulseAvg(), '', 5);
			$this->assertEquals( 169, $this->object->object()->getPulseMax(), '', 5);
			$this->assertTrue( $this->object->object()->hasArrayAltitude() );
			$this->assertTrue( $this->object->object()->hasArrayDistance() );
			$this->assertTrue( $this->object->object()->hasArrayHeartrate() );
			$this->assertTrue( $this->object->object()->hasArrayLatitude() );
			$this->assertTrue( $this->object->object()->hasArrayLongitude() );
			$this->assertTrue( $this->object->object()->hasArrayPace() );
			$this->assertTrue( $this->object->object()->hasArrayTime() );
			$this->assertTrue( $this->object->object()->hasArrayTemperature() );
			$this->assertTrue( $this->object->object()->hasArrayGroundContact() );
			$this->assertTrue( $this->object->object()->hasArrayVerticalOscillation() );

			$this->assertEquals( 216, $this->object->object()->getGroundContactTime() );
			$this->assertEquals( 92, $this->object->object()->getVerticalOscillation(), '', 1 );

			$this->assertEquals( 1, $this->object->object()->Sport()->id() );

			$this->assertFalse( $this->object->object()->Splits()->areEmpty() );
		}
	}

	/**
	 * Test: fenix file
	 * Filename: "Fenix-2.fit" 
	 */
	public function test_FenixFileWithPauses() {
		if (Shell::isPerlAvailable()) {
			$this->object->parseFile('../tests/testfiles/fit/Fenix-2-pauses.fit');

			$this->assertFalse( $this->object->hasMultipleTrainings() );
			$this->assertFalse( $this->object->failed() );

			$this->assertEquals( 46*60 + 50, $this->object->object()->getTimeInSeconds(), '', 5 );
			$this->assertEquals( 50*60 + 46, $this->object->object()->getElapsedTime() );
			$this->assertTrue( $this->object->object()->hasElapsedTime() );

			$this->assertEquals( 10.55, $this->object->object()->getDistance(), '', 0.1);
			$this->assertEquals( 564, $this->object->object()->getCalories(), '', 10);
			$this->assertEquals( 141, $this->object->object()->getPulseAvg(), '', 2);
			$this->assertEquals( 152, $this->object->object()->getPulseMax(), '', 2);
			$this->assertTrue( $this->object->object()->hasArrayAltitude() );
			$this->assertTrue( $this->object->object()->hasArrayDistance() );
			$this->assertTrue( $this->object->object()->hasArrayHeartrate() );
			$this->assertTrue( $this->object->object()->hasArrayLatitude() );
			$this->assertTrue( $this->object->object()->hasArrayLongitude() );
			$this->assertTrue( $this->object->object()->hasArrayPace() );
			$this->assertTrue( $this->object->object()->hasArrayTime() );
			$this->assertTrue( $this->object->object()->hasArrayTemperature() );

			$this->assertEquals( 1, $this->object->object()->Sport()->id() );

			$this->assertFalse( $this->object->object()->Splits()->areEmpty() );
			$this->assertEquals( "10.55|46:49", $this->object->object(2)->Splits()->asString() );

			$this->assertEquals( 46*60 + 50, $this->object->object()->getArrayTimeLastPoint(), '', 5 );
		}
	}

	/**
	 * Test: fenix file
	 * Filename: "Fenix-2.fit" 
	 */
	public function test_FenixFileNegativeTime() {
		if (!Shell::isPerlAvailable()) {
			$this->object->parseFile('../tests/testfiles/fit/Fenix-2-negative-times.fit');

			$this->assertFalse( $this->object->failed() );

			$this->assertEquals( "28.08.2014 09:32:59", date('d.m.Y H:i:s', $this->object->object()->getTimestamp()) );
			$this->assertEquals( 2*3600 + 35*60 + 21, $this->object->object()->getTimeInSeconds() );

			$this->assertTrue( $this->object->object()->hasArrayTime() );
			$this->assertTrue( min($this->object->object()->getArrayTime()) >= 0 );
		}
	}
}
