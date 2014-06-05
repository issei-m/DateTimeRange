<?php

class DateTimeRangeTest extends PHPUnit_Framework_TestCase 
{
    public function testConstructor()
    {
        $range = new DateTimeRange();
        $this->assertNull($range->getStart());
        $this->assertNull($range->getEnd());

        $range = new DateTimeRange(new DateTime(), new DateTime('+1 hour'));
        $this->assertEquals(new DateTime(), $range->getStart());
        $this->assertEquals(new DateTime('+1 hour'), $range->getEnd());
    }

    public function testAccessor()
    {
        $range = new DateTimeRange();
        $range
            ->setStart(new DateTime())
            ->setEnd(new DateTime('+1 hour'))
        ;
        $this->assertEquals(new DateTime(), $range->getStart());
        $this->assertEquals(new DateTime('+1 hour'), $range->getEnd());
    }

    public function testSerialize()
    {
        $range = new DateTimeRange();
        $range
            ->setStart(new DateTime())
            ->setEnd(new DateTime('+1 hour'))
        ;

        $newRange = unserialize(serialize($range));
        $this->assertEquals($range, $newRange);
    }
}
