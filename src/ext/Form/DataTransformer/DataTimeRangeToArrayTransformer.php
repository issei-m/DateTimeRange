<?php

namespace DateTimeRange\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms a DateTimeRange into an array.
 *
 * @package    Issei\DateTimeRange
 * @subpackage Form\DataTransformer
 * @author     Issei Murasawa <issei.m7@gmail.com>
 */
class DataTimeRangeToArrayTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (null === $value) {
            return array(
                'start' => null,
                'end'   => null,
            );
        }

        if (!$value instanceof \DateTimeRange) {
            throw new TransformationFailedException('Expected a DateTimeRange.');
        }

        return array(
            'start' => $value->getStart(),
            'end'   => $value->getEnd(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (
            false === is_array($value) ||
            false === array_key_exists('start', $value) ||
            false === array_key_exists('end', $value)
        ) {
            throw new TransformationFailedException('Expected an array containing both keys "start" and "end".');
        }

        foreach ($value as $k => $v) {
            if (null !== $v && !$v instanceof \DateTime) {
                throw new TransformationFailedException(sprintf('The "%s" must be NULL or instanceof \DateTime. (Actual: %s)', $k, gettype($v)));
            }
        }

        if (null !== $value['start'] || null !== $value['end']) {
            return new \DateTimeRange($value['start'], $value['end']);
        }
    }
}
