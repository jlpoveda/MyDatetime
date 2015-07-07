<?php
namespace MyDatetime\Tests;

use PHPUnit_Framework_TestCase;
use MyDatetime\MyDatetime;

class MyDatetimeTest extends PHPUnit_Framework_TestCase {

    public function testIfConstructorWorksWithValidTime()
    {
        $time = '12:3am';
        $sut = new MyDatetime($time);
        $this->assertEquals('12:03am', $sut->getTime());

        $time = '1:3am';
        $sut = new MyDatetime($time);
        $this->assertEquals('01:03am', $sut->getTime());

        $time = '1:3pm';
        $sut = new MyDatetime($time);
        $this->assertEquals('01:03pm', $sut->getTime());
    }

    public function testIfAddMinutesWorksWithValidValues()
    {
        $time = '12:3am';
        $sut = new MyDatetime($time);
        $sut->addMinutes(60);
        $this->assertEquals('01:03pm', $sut->getTime());

        $time = '6:3am';
        $sut = new MyDatetime($time);
        $sut->addMinutes(596);
        $this->assertEquals('03:59pm', $sut->getTime());
    }

}
