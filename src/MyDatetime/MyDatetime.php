<?php
namespace MyDatetime;

class MyDatetime
{
    /** @var string  */
    protected $date = '';

    /** @var int  */
    protected $hour = 0;

    /** @var int  */
    protected $minute = 0;

    /** @var string  */
    protected $indicator = '';

    /**
     * @param string $date
     */
    public function __construct($date)
    {
        $this->date = $this->getValidatedDate($date);
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return str_pad($this->hour, 2, '0', STR_PAD_LEFT) . ':' .
            str_pad($this->minute, 2, '0', STR_PAD_LEFT) .
            $this->indicator;
    }

    public function addMinutes($minutes)
    {
        $minutes = intval($minutes);
        if($minutes < 0) {
            throw new \InvalidArgumentException('No se permite restar minutos');
        }

        $result = $minutes + $this->minute;

        $hours = round($result / 60);
        $this->minute = $result % 60;
        $this->hour = $this->hour + $hours;

        $this->normalizeHour();
    }

    private function normalizeHour()
    {
        while($this->hour > 12) {
            $this->hour = $this->hour - 12;
            $this->toggleIndicator();
        }
    }

    private function toggleIndicator()
    {
        if($this->indicator == 'am') {
            $this->indicator = 'pm';
        } elseif($this->indicator == 'pm') {
            $this->indicator = 'am';
        } else {
            throw new \Exception('WTF!!!');
        }
    }

    /**
     * @param string $date
     * @return string
     */
    private function getValidatedDate($date)
    {
        if(!$date) {
            throw new \InvalidArgumentException("Date can not be null or empty");
        }

        $indicator = substr($date, strlen($date) - 2, 2);

        str_replace($indicator, '', $date);

        $timeParts = explode(':', $date);
        if(count($timeParts) != 2) {
            throw new \InvalidArgumentException('Invalid glue. You past white a semicolon to separate hours from minutes');
        }

        $this->getValidHour($timeParts[0]);
        $this->getValidMinute($timeParts[1]);
        $this->getValidIndicator($indicator);

        return $this->getTime();
    }

    private function getValidIndicator($indicator)
    {
        $indicator = strtolower($indicator);
        if('am' != $indicator && 'pm' != $indicator) {
            throw new \InvalidArgumentException('Invalid indicator. Only accepcted am or pm');
        }

        $this->indicator = $indicator;
    }

    private function getValidHour($hour)
    {
        if($hour != intval($hour)) {
            throw new \InvalidArgumentException('Invalid hour. Hour: ' . $hour);
        }

        $hour = intval($hour);

        if($hour < 0 || $hour > 12) {
            throw new \InvalidArgumentException('Invalid hour. Hour: ' . $hour);
        }

        $this->hour = $hour;
    }

    private function getValidMinute($minute)
    {
        if($minute != intval($minute)) {
            throw new \InvalidArgumentException('Invalid minute. Minute: ' . $minute);
        }

        $minute = intval($minute);

        if($minute < 0 || $minute > 12) {
            throw new \InvalidArgumentException('Invalid minute. Minute: ' . $minute);
        }

        $this->minute = $minute;
    }
}
