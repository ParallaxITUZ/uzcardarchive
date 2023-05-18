<?php

namespace App\Services;

use App\Models\Currency;

class CurrencyService
{
    public function Currency()
    {
        $response = Http::get('http://example.com');
        $currency = Currency::find()->where(['code' => 'usd', 'date' => date('Y-m-d')])->one();

        if($currency) {
            return $currency->rate;
        } else {
            $client = new Client();
            $response = $client->createRequest()
                ->setFormat(Client::FORMAT_JSON)
                ->setMethod('GET')
                ->setUrl('http://cbu.uz/oz/arkhiv-kursov-valyut/json/USD/' . date('Y-m-d'))
                ->send();
            $data = json_decode($response->getContent(), true);

            $currency = self::find()->where(['code' => 'usd'])->one();

            if(!empty($data) && count($data) == 1) {

                $currency->rate = $data[0]["Rate"];
                $currency->date = date('Y-m-d');
                $currency->save();
            }


            return $currency->rate;
        }
    }
}
