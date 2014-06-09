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
        $this->assertEquals([
            'start' => new \DateTime('2014/02/14'),
            'end'   => new \DateTime('2014/03/14'),
        ], $transformer->transform($range));
    }

    public function testTransformWithNull()
    {
        $transformer = new DataTimeRangeToArrayTransformer();
        $this->assertEquals([
            'start' => null,
            'end'   => null,
        ], $transformer->transform(null));
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
        ), $transformer->reverseTransform([
            'start' => new \DateTime('2014/02/14'),
            'end'   => new \DateTime('2014/03/14'),
        ]));
    }

    public function testReverseTransformWithRangeLackedBothSide()
    {
        $transformer = new DataTimeRangeToArrayTransformer();
        $this->assertNull($transformer->reverseTransform(['start' => null, 'end' => null,]));
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
        return [
            [
                [
                    'start' => null,
                    'end'   => new \DateTime('2014/03/14'),
                ],
                new \DateTimeRange(
                    null,
                    new \DateTime('2014/03/14')
                )
            ],
            [
                [
                    'start' => new \DateTime('2014/02/14'),
                    'end'   => null,
                ],
                new \DateTimeRange(
                    new \DateTime('2014/02/14'),
                    null
                )
            ],
        ];
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
        return [
            [
                null,
            ],
            [
                'string'
            ],
            [
                [
                    'start' => new \DateTime('2014/02/14'),
                ]
            ],
            [
                [
                    'end' => new \DateTime('2014/03/14'),
                ]
            ],
            [
                [
                    'start' => new \DateTime('2014/02/14'),
                    'end'   => 'string',
                ]
            ],
            [
                [
                    'start' => 'string',
                    'end'   => new \DateTime('2014/03/14'),
                ]
            ],
        ];
    }
}
