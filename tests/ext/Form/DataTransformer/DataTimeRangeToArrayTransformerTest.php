<?php

namespace DateTimeRange\Tests\DataTransformer;

use DateTimeRange\Form\DataTransformer\DataTimeRangeToArrayTransformer;

class DataTimeRangeToArrayTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testTransformWithDateTimeRange()
    {
        $range = $this->getMock('\DateTimeRange');

        $range->expects($this->once())->method('getStart')->will($this->returnValue(new \DateTime('2014/02/14')));
        $range->expects($this->once())->method('getEnd')->will($this->returnValue(new \DateTime('2014/03/14')));

        $transformer = new DataTimeRangeToArrayTransformer();
        $this->assertEquals(array(
            'start' => new \DateTime('2014/02/14'),
            'end'   => new \DateTime('2014/03/14'),
        ), $transformer->transform($range));
    }

    public function testTransformWithNull()
    {
        $transformer = new DataTimeRangeToArrayTransformer();
        $this->assertEquals(array(
            'start' => null,
            'end'   => null,
        ), $transformer->transform(null));
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testTransformWithUnexpectedType()
    {
        $transformer = new DataTimeRangeToArrayTransformer();
        $transformer->transform('string');
    }

    public function testReverseTransform()
    {
        $transformer = new DataTimeRangeToArrayTransformer();
        $this->assertEquals(new \DateTimeRange(
            new \DateTime('2014/02/14'),
            new \DateTime('2014/03/14')
        ), $transformer->reverseTransform(array(
            'start' => new \DateTime('2014/02/14'),
            'end'   => new \DateTime('2014/03/14'),
        )));
    }

    public function testReverseTransformWithRangeLackedBothSide()
    {
        $transformer = new DataTimeRangeToArrayTransformer();
        $this->assertNull($transformer->reverseTransform(array('start' => null, 'end' => null,)));
    }

    /**
     * @dataProvider lackedOneSideRangeProvider
     */
    public function testReverseTransformWithRangeLackedOneSide($range, $expectedRange)
    {
        $transformer = new DataTimeRangeToArrayTransformer();
        $this->assertEquals($expectedRange, $transformer->reverseTransform($range));
    }

    public function lackedOneSideRangeProvider()
    {
        return array(
            array(
                array(
                    'start' => null,
                    'end'   => new \DateTime('2014/03/14'),
                ),
                new \DateTimeRange(
                    null,
                    new \DateTime('2014/03/14')
                )
            ),
            array(
                array(
                    'start' => new \DateTime('2014/02/14'),
                    'end'   => null,
                ),
                new \DateTimeRange(
                    new \DateTime('2014/02/14'),
                    null
                )
            ),
        );
    }

    /**
     * @dataProvider unexpectedDataProvider
     *
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testReverseTransformWithUnexpectedData($data)
    {
        $transformer = new DataTimeRangeToArrayTransformer();
        $transformer->reverseTransform($data);
    }

    public function unexpectedDataProvider()
    {
        return array(
            array(
                null,
            ),
            array(
                'string'
            ),
            array(
                array(
                    'start' => new \DateTime('2014/02/14'),
                ),
            ),
            array(
                array(
                    'end' => new \DateTime('2014/03/14'),
                ),
            ),
            array(
                array(
                    'start' => new \DateTime('2014/02/14'),
                    'end'   => 'string',
                ),
            ),
            array(
                array(
                    'start' => 'string',
                    'end'   => new \DateTime('2014/03/14'),
                )
            ),
        );
    }
}
