<?php

class Clock
{
    private $stamp = 0;

    public function __construct($x = 0, $y = 0)
    {
        $this->stamp = $this->get_hour($x) * 60 * 60;
        $this->stamp = $this->stamp + ($this->get_min($y) * 60);
        $this->stamp = $this->normalize_stamp($this->stamp);
    }

    public function add($min)
    {
        $stamp = $this->stamp + ($this->get_min($min) * 60);
        $this->stamp = $this->normalize_stamp($stamp);
        return $this;
    }

    public function sub($min)
    {
        $add = (60 * 24) - $min;
        return $this->add($add);
    }

    private function get_hour($x)
    {
        if ($x < 0) {
            $x = $this->get_hour(24 + $x);
        } elseif ($x >= 24) {
            $x = $this->get_hour($x - 24);
        }
        return $x;
    }

    private function get_min($y)
    {
        $day = 60 * 60 * 24;
        return ($y <= 0) ? $this->get_min($day + $y) : $y;
    }

    private function normalize_stamp($stamp)
    {
        $day = 60 * 60 * 24;
        return ($stamp > $day) ? $this->normalize_stamp($stamp - $day) : $stamp;
    }

    private function result_hour($stamp)
    {
        $hour = floor($stamp / (60 * 60));
        $hour = ($hour == 24) ? 0 : $hour;
        return (strlen($hour) == 1) ? "0{$hour}" : $hour;
    }

    private function result_min($stamp)
    {
        $hour = $this->result_hour($stamp) * 60 * 60;
        $min = ($stamp - $hour) / 60;

        $min = ($min >= 60) ? 
            $this->normalize_min($min) : 
            $min;

        return (strlen($min) == 1) ? "0{$min}" : $min;
    }

    private function normalize_min($min = 0)
    {
        return ($min >= 60) ? $this->normalize_min($min - 60) : $min;
    }

    public function __toString()
    {
        $hour = $this->result_hour($this->stamp);
        $min = $this->result_min($this->stamp);
        return "{$hour}:{$min}";
    }
}