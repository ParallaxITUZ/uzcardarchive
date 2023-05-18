<?php

namespace Database\Seeders;

use App\Models\Dictionary;
use App\Models\DictionaryItem;
use Illuminate\Database\Seeder;

class RelativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relative = Dictionary::create([
            'name' => 'relations',
            'display_name' => ['uz' => 'Yaqin qarindosh', 'ru' => 'родственник'],
        ]);

         DictionaryItem::create([
            'display_name' => ['uz' => 'Ota ', 'ru' => 'Отец'],
            'dictionary_id' => $relative->id,
            'value' => '1',
            'name' => 'father',
        ]);
         DictionaryItem::create([
            'display_name' => ['uz' => 'Ona ', 'ru' => 'Мать'],
            'dictionary_id' => $relative->id,
            'value' => '2',
            'name' => 'mather',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Er ', 'ru' => 'Муж'],
            'dictionary_id' => $relative->id,
            'value' => '3',
            'name' => 'husband',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Xotin ', 'ru' => 'Жена'],
            'dictionary_id' => $relative->id,
            'value' => '4',
            'name' => 'wife',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'o\'gil ', 'ru' => 'Сын'],
            'dictionary_id' => $relative->id,
            'value' => '5',
            'name' => 'boy',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Qiz ', 'ru' => 'Дочь'],
            'dictionary_id' => $relative->id,
            'value' => '6',
            'name' => 'girl',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Aka ', 'ru' => 'Старший брат'],
            'dictionary_id' => $relative->id,
            'value' => '7',
            'name' => 'big brother',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Uka ', 'ru' => 'Младший брат'],
            'dictionary_id' => $relative->id,
            'value' => '8',
            'name' => 'little brother',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Opa ', 'ru' => 'Старшая сестра'],
            'dictionary_id' => $relative->id,
            'value' => '9',
            'name' => 'bid sister',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Singil ', 'ru' => 'Младшая сестра'],
            'dictionary_id' => $relative->id,
            'value' => '10',
            'name' => 'little sister',
        ]);

    }
}
