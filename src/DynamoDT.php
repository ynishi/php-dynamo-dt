<?php

/**
 * DynamoDT a util datetime for AWS DynamoDB
 *
 *
 * @package php-DynamoDT
 * @author  Yutaka Nishimura <ytk.nishimura@gmail.com>
 */
class DynamoDT
{
    // class instance
    private static $zero = null;

    // class method

    /**
     *
     * Create zero date(Epoch 0) use as zero value.
     *
     * @return DynamoDT
     */
    public static function zeroDate()
    {
        if (is_null(self::$zero)) {
            self::$zero = new DynamoDT('@0');
        }
        return self::$zero;
    }

    /**
     *
     * Return key "default" for construct default
     *
     * @return DynamoDT
     */
    public static function getDefault()
    {
        return "DEFAULT";
    }

    private static function getFormat()
    {
        return "Y-m-d\TH:i:s.uO";
    }

    private $innerDT = null;
    private $micro = "";

    /**
     *
     * Constructor for DynamoDT
     *
     * @param string $datetimeStr initial date str compatible with DateTime constructor.
     * @return DynamoDT
     */
    function __construct($datetimeStr)
    {
        if ($datetimeStr == self::getDefault()) {
            $epoch = microtime(true);
            $micro = sprintf("%06d", ($epoch - floor($epoch)) * 1000000);
            $this->innerDT = new DateTime(
                date('Y-m-d H:i:s.' . $micro, $epoch)
            );
        } else {
            $this->innerDT = new DateTime($datetimeStr);
        }
        $this->micro = $this->innerDT->format('u');
    }

    /**
     *
     * Constructor for DynamoDT
     *
     * @param string $datetimeStr initial date str conpatible with DateTime constructor.
     * @return DynamoDT
     */
    public function get()
    {
        return $this->innerDT;
    }

    /**
     *
     * Constructor for DynamoDT
     *
     * @param string $datetimeStr initial date str conpatible with DateTime constructor.
     * @return DynamoDT
     */
    public function getMicro()
    {
        return $this->micro;
    }

    /**
     *
     * Show formatted timestamp, explicit call to string
     *
     * @return string formatted timestamp
     */
    public function show()
    {
        return $this->__toString();
    }

    /**
     *
     * Special Method to string, format timestamp.
     *
     * @return string formatted timestamp
     */
    public function __toString()
    {
        // ISO8601 + micro
        return $this->innerDT->format(self::getFormat());
    }

    /**
     *
     * Check if this is zero.
     *
     * @return boolean if this is zero then true else false
     */
    public function isZero()
    {
        return $this->eq(self::$zero);
    }

    /**
     *
     * Check Equal by value this and param.
     *
     * @param DynamoDT target.
     * @return boolean if this equals param then true else false
     */
    public function eq($d)
    {
        return $this->show() == $d->show();
    }

    /**
     *
     * Check greater than by value this and param.
     *
     * @param DynamoDT target.
     * @return boolean if this greater than param then true else false
     */
    public function gt($d)
    {
        if ($this->get() == $d->get()) {
            return $this->getMicro() > $d->getMicro();
        }
        return $this->get() > $d->get();
    }

    /**
     *
     * Check less than by value this and param.
     *
     * @param DynamoDT target.
     * @return boolean if this less than param then true else false
     */
    public function lt($d)
    {
        return !$this->gt($d) && !$this->eq($d);
    }

    /**
     *
     * Move Before or After time and return new value, keep immutable.
     *
     * @param string compatible with Datetime->modify
     * @return DynamoDT moved new DynamoDT
     */
    public function move($modify_str)
    {
        $dt = new DateTime($this->show());
        $dt->modify($modify_str);
        return new DynamoDT($dt->format(self::getFormat()));
    }
}

