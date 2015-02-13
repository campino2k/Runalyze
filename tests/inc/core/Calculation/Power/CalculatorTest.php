<?php

namespace Runalyze\Calculation\Power;

use Runalyze\Model\Trackdata;
use Runalyze\Model\Route;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2015-02-13 at 17:21:28.
 */
class CalculatorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @see http://www.gribble.org/cycling/power_v_speed.html
	 */

	public function testEmptyExample() {
		$Calculator = new Calculator(
			new Trackdata\Object(array(
			)),
			new Route\Object(array(
			))
		);
		$Calculator->calculate();

		$this->assertEquals(0, $Calculator->average());
		$this->assertEmpty($Calculator->powerData());
	}

	/**
	 * Flat Road, 20 mph:  Total Power = 26 +108 = 134 watts
	 */
	public function testFastExampleFromUltracycle() {
		$Calculator = new Calculator(
			new Trackdata\Object(array(
				Trackdata\Object::DISTANCE => array(1*0.0892, 2*0.0892, 3*0.0892, 4*0.0892, 5*0.0892, 6*0.0892),
				Trackdata\Object::TIME => array(10, 20, 30, 40, 50, 60)
			))
		);
		$Calculator->calculate(75, 1.0);

		$this->assertEquals(134, $Calculator->average(), '', 1);
	}

	/**
	 * Flat Road, 5 mph: Total Power = 6.5 + 1.7 = 8.2 watts
	 **/
	public function testSlowExampleFromUltracycle() {
		$Calculator = new Calculator(
			new Trackdata\Object(array(
				Trackdata\Object::DISTANCE => array(1*0.0223, 2*0.0223, 3*0.0223, 4*0.0223, 5*0.0223, 6*0.0223),
				Trackdata\Object::TIME => array(10, 20, 30, 40, 50, 60)
			))
		);
		$Calculator->calculate(75, 1.0);

		$this->assertEquals(8, $Calculator->average(), '', 1);
	}

	/**
	 * Climb, 5 mph, 12% grade: Total Power = 6.5 + 1.7 + 196 = 204 watts
	 */
	public function testClimbExampleFromUltracycle() {
		$Calculator = new Calculator(
			new Trackdata\Object(array(
				Trackdata\Object::DISTANCE => array(1*0.0223, 2*0.0223, 3*0.0223, 4*0.0223, 5*0.0223, 6*0.0223),
				Trackdata\Object::TIME => array(10, 20, 30, 40, 50, 60)
			)),
			new Route\Object(array(
				// Remark: 0.0223 is in km, but elevation in m
				Route\Object::ELEVATIONS_ORIGINAL => array(100, 100 + 0.12*22.3, 100 + 2*0.12*22.3, 100 + 3*0.12*22.3, 100 + 4*0.12*22.3, 100 + 5*0.12*22.3)
			))
		);
		$Calculator->calculate(75, 1.0);

		$this->assertEquals(205, $Calculator->average());
		$this->assertEquals(
			array(205, 205, 205, 205, 205, 205),
			$Calculator->powerData()
		);
	}

	public function testChangingValues() {
		$Calculator = new Calculator(
			new Trackdata\Object(array(
				Trackdata\Object::DISTANCE => array(0.1, 0.2, 0.3, 0.4, 0.5, 0.6),
				Trackdata\Object::TIME => array(10, 20, 30, 40, 50, 60)
			)),
			new Route\Object(array(
				Route\Object::ELEVATIONS_ORIGINAL => array(0, 1, 3, 8, 3, 3)
			))
		);
		$Calculator->calculate(75, 1.0);

		$this->assertEquals(
			array(256, 330, 550, 0, 183, 183),
			$Calculator->powerData()
		);
	}

}
