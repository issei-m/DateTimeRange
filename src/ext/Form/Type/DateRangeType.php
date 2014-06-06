<?php

namespace DateTimeRange\Form\Type;

use DateTimeRange\Form\DataTransformer\DataTimeRangeToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @package    DateTimeRange
 * @subpackage Form\Type
 * @author     Issei Murasawa <issei.m7@gmail.com>
 */
class DateRangeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addViewTransformer(new DataTimeRangeToArrayTransformer())
            ->add('start', 'date', [
                'widget' => $options['widget'],
                'format' => $options['format'],
            ])
            ->add('end', 'date', [
                'widget' => $options['widget'],
                'format' => $options['format'],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'widget'     => 'single_text',
            'format'     => 'yyyy/MM/dd',
            'data_class' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'date_range';
    }
}
