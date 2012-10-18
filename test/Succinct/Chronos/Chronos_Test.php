<?php

use Succinct\Chronos\Chronos;

class Chronos_Test extends PHPUnit_Framework_TestCase {

	protected $chronos = NULL;

	protected function setUp() {
		parent::setUp();
		$this->chronos = new Chronos('2010-09-08 17:16:15');
	}

	/**
	 * @dataProvider ymd_data
	 */
	public function testYmd($delimiter, $expected) {
		$date = $this->chronos->ymd($delimiter);
		$this->assertSame($date, $expected);
	}

	/**
	 * @dataProvider his_data
	 */
	public function testHis($delimiter, $expected) {
		$date = $this->chronos->his($delimiter);
		$this->assertSame($date, $expected);
	}

	public function testDay() {
		$date = $this->chronos->day();
		$this->assertSame($date, 'Wed');
	}


	public function ymd_data() {
		return array(
			array(NULL, '2010-09-08')
			, array('-', '2010-09-08')
			, array('/', '2010/09/08')
			, array(' ', '2010 09 08')
			, array(FALSE, '20100908')
		);
	}


	public function his_data() {
		return array(
			array(NULL, '17:16:15')
			, array('-', '17-16-15')
			, array('/', '17/16/15')
			, array(' ', '17 16 15')
			, array(FALSE, '171615')
		);
	}

}
