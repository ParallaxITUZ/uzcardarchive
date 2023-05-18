<?php

namespace App\Structures;

use Carbon\Carbon;
use Illuminate\Support\Str;

class BankCard
{
    protected $pan;
    protected $expire;
    protected $expire_date;

    public function __construct(string $pan, string $expire)
    {
        $this->pan = preg_replace('/[^0-9]+/', '', $pan);
        $this->expire = preg_replace('/[^0-9]+/', '', $expire);
        // 0224
        $expire_month = Str::substr($this->expire, 0, 2);
        $expire_year = '20' . Str::substr($this->expire, 2, 2);
        //$this->expire_date = Carbon::createFromFormat('my', $this->expire)->endOfMonth();
        $this->expire_date = Carbon::create(intval($expire_year),intval($expire_month))->endOfMonth();
    }

    public function getPan()
    {
        return $this->pan;
    }

    public function getMaskedPan()
    {
        return substr($this->pan, 0, 4) . str_repeat('*', strlen($this->pan) - 8) . substr($this->pan, -4);
    }

    public function getExpire()
    {
        return $this->expire;
    }

    public function getExpireReversed()
    {
        return $this->expire_date->format('ym');
    }

    public function getExpireDate(): Carbon
    {
        return $this->expire_date;
    }

    public function isEqual(BankCard $bankCard)
    {
        return $bankCard->getExpire() === $this->expire && $bankCard->getPan() === $this->pan;
    }
}
