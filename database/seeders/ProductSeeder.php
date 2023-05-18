<?php

namespace Database\Seeders;

use App\Models\Dictionary;
use App\Models\DictionaryItem;
use App\Models\Policy;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insurance_object = Dictionary::create([
            'name' => 'insurance_objects',
            'display_name' => ['uz' => 'Sugurta obyekti', 'ru' => 'объект страхования'],
        ]);
        $insurance_types = Dictionary::create([
            'name' => 'insurance_types',
            'display_name' => ['uz' => 'Виды страхования', 'ru' => 'Виды страхования '],
        ]);
        $periods = Dictionary::create([
            'name' => 'periods',
            'display_name' => ['uz' => 'мин макс кол-во дней', 'ru' => 'мин макс кол-во дней'],
        ]);
        $currencies = Dictionary::create([
            'name' => 'currencies',
            'display_name' => ['uz' => 'Валюта', 'ru' => 'Валюта'],
        ]);
        $insurance_classes = Dictionary::create([
            'name' => 'insurance_classes',
            'display_name' => ['uz' => 'Отрасль общего страхования', 'ru' => 'Отрасль общего страхования'],
        ]);
        $insurance_forms = Dictionary::create([
            'name' => 'insurance_forms',
            'display_name' => ['uz' => 'Форма страхования', 'ru' => 'Форма страхования'],
        ]);

        DictionaryItem::create([
            'display_name' => ['uz' => 'moshina', 'ru' => 'moshina'],
            'dictionary_id' => $insurance_object->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'uy', 'ru' => 'dom'],
            'dictionary_id' => $insurance_object->id,
        ]);

        DictionaryItem::create([
            'display_name' => ['uz' => 'Личное', 'ru' => 'Личное'],
            'dictionary_id' => $insurance_types->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'имущественное', 'ru' => 'имущественное'],
            'dictionary_id' => $insurance_types->id,
        ]);

        DictionaryItem::create([
            'display_name' => ['uz' => 'гибкий', 'ru' => 'гибкий'],
            'dictionary_id' => $periods->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'фиксированный', 'ru' => 'фиксированный'],
            'dictionary_id' => $periods->id,
        ]);

        DictionaryItem::create([
            'display_name' => ['uz' => 'USD', 'ru' => 'USD'],
            'dictionary_id' => $currencies->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'UZS', 'ru' => 'UZS'],
            'dictionary_id' => $currencies->id,
        ]);

        DictionaryItem::create([
            'display_name' => ['uz' => 'Страхование от несчастных случаев', 'ru' => 'Страхование от несчастных случаев'],
            'dictionary_id' => $insurance_classes->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Страхование на случай болезни', 'ru' => 'Страхование на случай болезни'],
            'dictionary_id' => $insurance_classes->id,
        ]);

        DictionaryItem::create([
            'display_name' => ['uz' => 'Обязательное', 'ru' => 'Обязательное'],
            'dictionary_id' => $insurance_forms->id,
        ]);
        Product::query()->create([
            'name' => 'travel',
            'description' => 'wwww',
            'dictionary_insurance_object_id' => '32',
            'insurance_form_id' => '12',
            'insurance_type_id' => '35',
            'period_type_id' => '37',
            'currency_id' => '1',
            'single_payment' => 'false',
            'multi_payment' => 'true',
            'tariff_scale_from' => '0',
            'tariff_scale_to' => '2.5',

            'policy_id' => 1,
            'status' => 1
        ]);

        Product::query()->create([
            'name' => 'osago',
            'description' => 'wwww',
            'dictionary_insurance_object_id' => '32',
            'insurance_form_id' => '12',
            'insurance_type_id' => '35',
            'period_type_id' => '37',
            'currency_id' => '1',
            'single_payment' => 'false',
            'multi_payment' => 'true',
            'tariff_scale_from' => '0',
            'tariff_scale_to' => '2.5',

            'policy_id' => 2,
            'status' => 1
        ]);
    }
}
