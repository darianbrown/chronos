<?php

namespace Succinct\Chronos;

use PHPUnit_Framework_TestCase;
use InvalidArgumentException;

class ObjectToString
{
    public function __toString()
    {
        return '+1 day';
    }
}

class Chronos_Test extends PHPUnit_Framework_TestCase
{

    protected $chronos = NULL;

    protected function setUp()
    {
        parent::setUp();

        $this->chronos = new Chronos('2010-09-08 17:16:15');
    }

    public function constructorData()
    {
        return array(
            'Null'                    => array(null),
            'Date String'             => array('2010-09-08 17:16:15'),
            'Unix timestamp'          => array(1234567890),
            'Unix string timestamp'   => array('1234567890'),
            'Chronos instance'        => array(Chronos::now()),
            'Object with __toString'  => array(new ObjectToString),
        );
    }
    /**
     * @dataProvider constructorData
     */
    public function testConstructor($date)
    {
        $chronos = new Chronos($date);

        $this->assertInstanceOf(__NAMESPACE__ . "\Chronos", $chronos);
    }

    public function constructorFailureData()
    {
        return array(
            'False'                     => array(false),
            'True'                      => array(true),
            'Empty string'              => array(''),
            'Object with no __toString' => array((object) array('foo', 'bar', 'baz')),
            'Array'                     => array(array('1234567890')),
            'stdClass'				    => array(new \stdClass),
            'Exception'				    => array(new \Exception),
            'Invalid date string'       => array('foo')
        );
    }
    /**
     * @dataProvider constructorFailureData
     */
    public function testConstructorFailure($date)
    {
        $this->setExpectedException('InvalidArgumentException');

        $chronos = new Chronos($date);
    }

    public function testToday()
    {
        $chronos = Chronos::today();

        $this->assertSame(date('Y-m-d'), $chronos->ymd());
    }

    public function testTomorrow()
    {
        $chronos = Chronos::tomorrow();

        $this->assertSame(date('Y-m-d', strtotime('+1 day')), $chronos->ymd());
    }

    public function testYesterday()
    {
        $chronos = Chronos::yesterday();

        $this->assertSame(date('Y-m-d', strtotime('-1 day')), $chronos->ymd());
    }

    public function testNow()
    {
        $chronos = Chronos::now();

        $this->assertSame(date('Y-m-d H:i:s'), $chronos->ymdhis());
    }

    public function testTimestamp()
    {
        $timestamp = strtotime('2010-09-08 17:16:15');
        $chronos = new Chronos('2010-09-08 17:16:15');

        $this->assertSame($timestamp, $chronos->timestamp());
    }

    public function agoData()
    {
        return array(
            '1 second ago' => array('-1 second', 'a few moments ago'),
            '9 second ago' => array('-9 second', 'a few moments ago'),
            '10 seconds ago' => array('-10 second', '10 seconds ago'),
            '59 seconds ago' => array('-59 second', '59 seconds ago'),
            '1 minute ago' => array('-60 second', '1 minutes ago'),
        );
    }

    /**
     * @dataProvider agoData
     */
    public function testAgo($dateString, $expected)
    {
        $date = new Chronos($dateString);
        $this->assertSame($expected, $date->ago());
    }

    public function ymd_data()
    {
        return array(
            array(NULL, '2010-09-08')
            , array('-', '2010-09-08')
            , array('/', '2010/09/08')
            , array(' ', '2010 09 08')
            , array(FALSE, '20100908')
        );
    }

    /**
     * @dataProvider ymd_data
     */
    public function testYmd($delimiter, $expected)
    {
        $date = $this->chronos->ymd($delimiter);

        $this->assertSame($expected, $date);
    }

    public function his_data()
    {
        return array(
            array(NULL, '17:16:15')
            , array('-', '17-16-15')
            , array('/', '17/16/15')
            , array(' ', '17 16 15')
            , array(FALSE, '171615')
        );
    }

    /**
     * @dataProvider his_data
     */
    public function testHis($delimiter, $expected)
    {
        $date = $this->chronos->his($delimiter);

        $this->assertSame($expected, $date);
    }

    public function testDay()
    {
        $day = $this->chronos->day();

        $this->assertSame('Wed', $day);
    }

    public function testDoy()
    {
        $doy = $this->chronos->doy();

        $this->assertSame(250, $doy);
    }

    public function testDow()
    {
        $dow = $this->chronos->dow();

        $this->assertSame(3, $dow);
    }

    public function testWeek()
    {
        $week = $this->chronos->week();

        $this->assertSame(36, $week);
    }

    public function formatData()
    {
        return array(
            'False' => array(false, ''),
            'Null' => array(null, ''),
            'Year' => array('Y', '2010'),
            'Month number' => array('m', '09'),
            'Month short string' => array('M', 'Sep'),
            'String with hour' => array('\f\o\o: H', 'foo: 17'),
        );
    }
    /**
     * @dataProvider formatData
     */
    public function testFormat($format, $expectedResult)
    {
        $date = $this->chronos->format($format);

        $this->assertSame($expectedResult, $date);
    }
}
