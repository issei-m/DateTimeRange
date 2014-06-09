<?php

/**
 * DateTimeRange.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class DateTimeRange implements Serializable
{
    /**
     * @var DateTime
     */
    private $start;

    /**
     * @var DateTime
     */
    private $end;

    /**
     * Constructor.
     *
     * @param DateTime $start
     * @param DateTime $end
     */
    public function __construct(DateTime $start = null, DateTime $end = null)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
            $this->start,
            $this->end,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($this->start, $this->end) = unserialize($serialized);
    }

    /**
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param  DateTime $begin
     * @return $this
     */
    public function setStart($begin)
    {
        $this->start = $begin;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param  DateTime $end
     * @return $this
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }
}
