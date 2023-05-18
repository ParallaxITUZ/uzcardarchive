<?php

namespace Database\Seeders;

use App\Models\Dictionary;
use App\Models\DictionaryItem;
use Illuminate\Database\Seeder;

class ReContractReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reason_osago = Dictionary::create([
            'name' => 'reason_osago',
            'display_name' => ['uz' => 'Reason Osago', 'ru' => 'Причина Osago'],
        ]);

        DictionaryItem::create([
            'display_name' => ['uz' => 'Biror kishini qo\'shish. ', 'ru' => 'Добавление персоны.'],
            'dictionary_id' => $reason_osago->id,
            'value' => '',
            'name' => 'Adding a person',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Avtomobil raqamini o\'zgartirganda. ', 'ru' => 'При смене номера автомобиля.'],
            'dictionary_id' => $reason_osago->id,
            'value' => '',
            'name' => 'When changing the car number',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Haydovchilik guvohnomasini o\'zgartirish. ', 'ru' => 'Изменение водительских прав.'],
            'dictionary_id' => $reason_osago->id,
            'value' => '',
            'name' => 'Change of driver\'s license.',
        ]);
    }
}
