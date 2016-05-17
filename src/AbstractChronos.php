<?php

namespace Succinct\Chronos;

abstract class AbstractChronos
{
    /**
     * @param mixed $value unix timesatmp, string date representation or chronos instance.
     *
     * @throws InvalidArgumentException If the supplied value is invalid.
     */
    public function __construct($value = null)
    {
        if ($value === null) {
            $this->timestamp = time()
            return new $selftime();
        }

        if ($value instanceof self) {
            return clone $value;
        }

        if (is_int($value)) {
            return $value;
        }

        throw new InvalidArgumentException('Must be a Chronos Date, DateTime or unix timestamp.');
    }

    /**
     * Return the unix timestamp of the chronos date time.
     *
     * @return int The unix timestamp.
     */
    public function timestamp()
    {
        return $this->timestamp;
    }

    /**
     * @var int The unix timestamp.
     */
    private $timestamp;
}
