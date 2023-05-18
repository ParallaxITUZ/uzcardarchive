<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'rate',
        'date',
    ];

    public static function getUSDRate() {
        $currency = self::query()
            ->where('code', 'usd')
            ->where('date', date('Y-m-d'))
            ->first();

        if($currency) {
            return $currency->rate;
        } else {
            $url = 'http://cbu.uz/oz/arkhiv-kursov-valyut/json/USD/' . date('Y-m-d');
            $response = Http::get($url);

            if($response->ok()) {
                $currency_new = self::query()->where('code', 'usd')->first();
                $rate = $response[0]["Rate"];

                if($currency_new) {
                    $currency_new->update([
                        'rate' => $rate,
                        'date' => date('d.m.Y')
                    ]);
                } else {
                    $currency_new = self::query()->create([
                        'code' => 'usd',
                        'rate' => $rate,
                        'date' => date('d.m.Y'),
                    ]);
                }

                return $currency_new->rate;
            } else {
                return self::getUSDRate();
            }
        }
    }
}
