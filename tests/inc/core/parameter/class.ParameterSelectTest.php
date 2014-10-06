<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2014-09-15 at 19:10:07.
 */
class ParameterSelectTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var ParameterSelect
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->object = new ParameterSelect('a', array('options' => array('a' => 'one', 'b' => 'two', 'c' => 'three')));
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {
		
	}

	/**
	 * @covers ParameterSelect::value
	 */
	public function testSet() {
		$this->assertEquals('a', $this->object->value());
		$this->assertEquals('a', $this->object->valueAsString());

		$this->object->set('c');
		$this->assertEquals('c', $this->object->value());
		$this->assertEquals('c', $this->object->valueAsString());
	}

	/**
	 * @covers ParameterSelect::valueAsLongString
	 */
	public function testLongString() {
		$this->assertEquals('one', $this->object->valueAsLongString());

		$this->object->set('c');
		$this->assertEquals('three', $this->object->valueAsLongString());
	}

	/**
	 * @covers ParameterSelect::options
	 */
	public function testOptions() {
		$this->assertEquals( array('a' => 'one', 'b' => 'two', 'c' => 'three'), $this->object->options() );
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInvalidOption() {
		$this->object->set('foobar');
	}

	public function testWithoutOptions() {
		$Object = new ParameterSelect('');
		$this->assertEquals( '', $Object->value() );
		$this->assertEquals( '', $Object->valueAsString() );
	}

}
