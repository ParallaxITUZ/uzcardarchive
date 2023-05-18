<?php

namespace App\Structures;

class Phone
{
    protected $phone;
    protected $phone_without_prefix;

    public function __construct(?string $phone)
    {
        $phone = preg_replace('/[^0-9]+/', '', $phone);

        if (strlen($phone) === 9) {
            $this->phone_without_prefix = preg_replace('/[^0-9]+/', '', $phone);
            $this->phone = '998' . preg_replace('/[^0-9]+/', '', $phone);
        } else if (strlen($phone) === 12 || (substr($phone, 0, 1) === '+' && strlen($phone) === 13)) {
            $this->phone = preg_replace('/[^0-9]+/', '', $phone);
            $this->phone_without_prefix = substr($this->phone, 3);
        }
    }

    public function getFull(bool $return_as_string = true)
    {
        return $return_as_string ? $this->phone : intval($this->phone);
    }

    public function getShort(bool $return_as_string = true)
    {
        return $return_as_string ? $this->phone_without_prefix : intval($this->phone_without_prefix);
    }

    public function getMasked()
    {
        $res = "";
        if ($this->phone) {
            $res = $this->phone;
            for ($i = 6; $i < 10; $i++) {
                $res = substr_replace($res, "*", $i, 1);
            }
        }
        return $res;
    }

    public static function parseFull(?string $phone)
    {
        $phone = preg_replace('/[^0-9]+/', '', $phone);
        if (strlen($phone) === 12) {
            return $phone;
        } else if (strlen($phone) === 9) {
            return "998" . $phone;
        }
        return null;
    }

    public function __toString()
    {
        return $this->phone;
    }
}
