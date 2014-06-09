<?php

namespace DateTimeRange\Tests\Type;

use DateTimeRange\Form\Type\DateRangeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class DateRangeTypeTest extends TypeTestCase
{
    /**
     * @var FormInterface
     */
    private $form;

    protected function getExtensions()
    {
        $dateType = new DateType();

        return array(
            new PreloadedExtension(array(
                $dateType->getName() => $dateType,
            ), array()),
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->form = $this->factory->create(new DateRangeType());
    }

    public function testSubmit()
    {
        $this->form->submit(array(
            'start' => '2014/02/14',
            'end'   => '2014/03/14',
        ));

        $this->assertTrue($this->form->isValid());
        $this->assertEquals(
            new \DateTimeRange(
                new \DateTime('2014/02/14'),
                new \DateTime('2014/03/14')
            ),
            $this->form->getData()
        );
    }

    /**
     * @test
     */
    public function data_should_be_able_to_be_submitted_lacked_one_side()
    {
        $this->form->submit(array(
            'start' => '2014/02/14',
        ));

        $this->assertTrue($this->form->isValid());

        /** @var $range \DateTimeRange */
        $range = $this->form->getData();
        $this->assertEquals(new \DateTime('2014/02/14 00:00:00'), $range->getStart());
        $this->assertNull($range->getEnd());
    }

    /**
     * @test
     */
    public function data_should_be_null_if_submit_empty()
    {
        $this->form->submit(array());

        $this->assertTrue($this->form->isValid());
        $this->assertNull($this->form->getData());
    }
}
