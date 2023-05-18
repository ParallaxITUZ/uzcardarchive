<?php

namespace Database\Seeders;

use App\Models\Dictionary;
use App\Models\DictionaryItem;
use App\Models\ProductTariff;
use App\Models\ProductTariffBonus;
use App\Models\ProductTariffCondition;
use App\Models\ProductTariffConfiguration;
use App\Models\ProductTariffRisk;
use Illuminate\Database\Seeder;

class ClientContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = Dictionary::create([
            'name' => 'countries',
            'display_name' => ['uz' => 'Davlatlar', 'ru' => 'Davlatlar'],
        ]);

        $europe = DictionaryItem::create([
            'display_name' => ['uz' => 'Yevropa', 'ru' => 'Yevropa'],
            'dictionary_id' => $countries->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Turkiya', 'ru' => 'Turkiya'],
            'dictionary_id' => $countries->id,
            'parent_id' => $europe->id
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Angliya', 'ru' => 'Angliya'],
            'dictionary_id' => $countries->id,
            'parent_id' => $europe->id
        ]);

        $schengen = DictionaryItem::create([
            'display_name' => ['uz' => 'Shengen', 'ru' => 'Shengen'],
            'dictionary_id' => $countries->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Germaniya', 'ru' => 'Germaniya'],
            'dictionary_id' => $countries->id,
            'parent_id' => $schengen->id
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Italiya', 'ru' => 'Italiya'],
            'dictionary_id' => $countries->id,
            'parent_id' => $schengen->id
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Latviya', 'ru' => 'Latviya'],
            'dictionary_id' => $countries->id,
            'parent_id' => $schengen->id
        ]);

        $asia = DictionaryItem::create([
            'display_name' => ['uz' => 'MDH', 'ru' => 'СНГ'],
            'dictionary_id' => $countries->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Rossiya', 'ru' => 'Rossiya'],
            'dictionary_id' => $countries->id,
            'parent_id' => $asia->id
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Ozarbayjon', 'ru' => 'Азербайжан'],
            'dictionary_id' => $countries->id,
            'parent_id' => $asia->id
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Belarusiya', 'ru' => 'Беларусия'],
            'dictionary_id' => $countries->id,
            'parent_id' => $asia->id
        ]);



        $tariff1 = ProductTariff::create([
            'name' => 'Tarif 1',
            'description' => 'Tarif 1 description',
            'product_id' => '1',
            'status' => '1',
        ]);
        $tariff2 = ProductTariff::create([
            'name' => 'Tarif 2' ,
            'description' => 'Tarif 2 description',
            'product_id' => '1',
            'status' => '1',
        ]);
        $tariff3 = ProductTariff::create([
            'name' => 'Tarif 3' ,
            'description' => 'Tarif 3 description',
            'product_id' => '1',
            'status' => '1',
        ]);

        ProductTariffCondition::create([
            'dictionary_item_id' => $asia->id,
            'product_tariff_id' => $tariff1->id,
        ]);

        ProductTariffCondition::create([
            'dictionary_item_id' => $europe->id,
            'product_tariff_id' => $tariff3->id,
        ]);

        $product_tariff_condition = ProductTariffCondition::create([
            'dictionary_item_id' => $schengen->id,
            'product_tariff_id' => $tariff2->id,
        ]);

        $product_tariff_bonus = ProductTariffBonus::query()->create([
            'dictionary_item_id' => $schengen->id,
            'product_tariff_condition_id' => $product_tariff_condition->id,
            'name' => 'Schengen',
            'value' => 15,
            'status' => 1
        ]);

        $purpose = Dictionary::create([
            'name' => 'purposes',
            'display_name' => ['uz' => 'Sayohat maqsadi', 'ru' => 'Цель поездки'],
        ]);

        $travel = DictionaryItem::create([
            'display_name' => ['uz' => 'Sayohat', 'ru' => 'Путешествие'],
            'dictionary_id' => $purpose->id,
        ]);

        $sport = DictionaryItem::create([
            'display_name' => ['uz' => 'Sport', 'ru' => 'Спорт'],
            'dictionary_id' => $purpose->id,
        ]);

        $class_a = DictionaryItem::create([
            'display_name' => ['uz' => 'Klass A', 'ru' => 'Класс А'],
            'dictionary_id' => $purpose->id,
            'parent_id' => $sport->id
        ]);

        $class_b = DictionaryItem::create([
            'display_name' => ['uz' => 'Klass B', 'ru' => 'Класс Б'],
            'dictionary_id' => $purpose->id,
            'parent_id' => $sport->id
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $travel->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 1,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $travel->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 1,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $travel->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 1,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $class_a->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 1.4,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $class_a->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 1.4,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $class_a->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 1.4,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $class_b->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 2,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $class_b->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 2,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $class_b->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 2,
            'status' => 1
        ]);

        $days = Dictionary::create([
            'name' => 'days',
            'display_name' => ['uz' => 'Kunlar', 'ru' => 'Дни'],
        ]);

        $days1_8 = DictionaryItem::create([
            'display_name' => ['uz' => '1 - 8 kun', 'ru' => '1 – 8 дней'],
            'dictionary_id' => $days->id,
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days1_8->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 1,
            'option_to' => 8,
            'value' => 0.62,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days1_8->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 1,
            'option_to' => 8,
            'value' => 0.81,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days1_8->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 1,
            'option_to' => 8,
            'value' => 0.74,
            'status' => 1
        ]);

        $days9_15 = DictionaryItem::create([
            'display_name' => ['uz' => '9 - 15 kun', 'ru' => '9 - 15 дней'],
            'dictionary_id' => $days->id,
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days9_15->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 9,
            'option_to' => 15,
            'value' => 0.57,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days9_15->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 9,
            'option_to' => 15,
            'value' => 0.76,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days9_15->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 9,
            'option_to' => 15,
            'value' => 0.69,
            'status' => 1
        ]);

        $days16_30 = DictionaryItem::create([
            'display_name' => ['uz' => '16 - 30 kun', 'ru' => '16 – 30 дней'],
            'dictionary_id' => $days->id,
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days16_30->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 16,
            'option_to' => 30,
            'value' => 0.48,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days16_30->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 16,
            'option_to' => 30,
            'value' => 0.71,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days16_30->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 16,
            'option_to' => 30,
            'value' => 0.59,
            'status' => 1
        ]);

        $days31_44 = DictionaryItem::create([
            'display_name' => ['uz' => '31 - 44 kun', 'ru' => '31 – 44 дней'],
            'dictionary_id' => $days->id,
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days31_44->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 31,
            'option_to' => 44,
            'value' => 0.43,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days31_44->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 31,
            'option_to' => 44,
            'value' => 0.62,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days31_44->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 31,
            'option_to' => 44,
            'value' => 0.54,
            'status' => 1
        ]);

        $days45_60 = DictionaryItem::create([
            'display_name' => ['uz' => '45 - 60 kun', 'ru' => '45 – 60 дней'],
            'dictionary_id' => $days->id,
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days45_60->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 45,
            'option_to' => 60,
            'value' => 0.38,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days45_60->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 45,
            'option_to' => 60,
            'value' => 0.57,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days45_60->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 45,
            'option_to' => 60,
            'value' => 0.49,
            'status' => 1
        ]);

        $days61_92 = DictionaryItem::create([
            'display_name' => ['uz' => '61 - 92 kun', 'ru' => '61 – 92 дней'],
            'dictionary_id' => $days->id,
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days61_92->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 61,
            'option_to' => 92,
            'value' => 0.38,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days61_92->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 61,
            'option_to' => 92,
            'value' => 0.52,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days61_92->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 61,
            'option_to' => 92,
            'value' => 0.44,
            'status' => 1
        ]);

        $days92_183 = DictionaryItem::create([
            'display_name' => ['uz' => '92 - 183 kun', 'ru' => '92 – 183 дней'],
            'dictionary_id' => $days->id,
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days92_183->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 92,
            'option_to' => 183,
            'value' => 0.38,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days92_183->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 92,
            'option_to' => 183,
            'value' => 0.57,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days92_183->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 92,
            'option_to' => 183,
            'value' => 0.59,
            'status' => 1
        ]);

        $days184_365 = DictionaryItem::create([
            'display_name' => ['uz' => '184 - 365 kun', 'ru' => '184 – 365 дней'],
            'dictionary_id' => $days->id,
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days184_365->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 184,
            'option_to' => 365,
            'value' => 0.38,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days184_365->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 184,
            'option_to' => 365,
            'value' => 0.52,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $days184_365->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 184,
            'option_to' => 365,
            'value' => 0.54,
            'status' => 1
        ]);

        $multiple = Dictionary::create([
            'name' => 'multiple',
            'display_name' => ['uz' => 'Ko`p martalik', 'ru' => 'Многократный полис'],
        ]);

        $multiple30 = DictionaryItem::create([
            'display_name' => ['uz' => '92 kun ichida 30 kun bo`lish', 'ru' => '30 дней пребывания в течение 92 дней'],
            'dictionary_id' => $multiple->id,
        ]);

        $multiple90 = DictionaryItem::create([
            'display_name' => ['uz' => '183 kun ichida 90 kun bo`lish', 'ru' => '90 дней пребывания в течение 183 дней'],
            'dictionary_id' => $multiple->id,
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $multiple30->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 30,
            'option_to' => 92,
            'value' => 25,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $multiple30->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 30,
            'option_to' => 92,
            'value' => 29,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $multiple30->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 30,
            'option_to' => 92,
            'value' => 29,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $multiple90->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 60,
            'option_to' => 183,
            'value' => 69,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $multiple90->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 60,
            'option_to' => 183,
            'value' => 57,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $multiple90->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 60,
            'option_to' => 183,
            'value' => 59,
            'status' => 1
        ]);

        // Age
        $age = Dictionary::create([
            'name' => 'age',
            'display_name' => ['uz' => 'Yosh', 'ru' => 'Возраст'],
        ]);

        $age1 = DictionaryItem::create([
            'display_name' => ['uz' => '66 - 70', 'ru' => '66 - 70'],
            'dictionary_id' => $age->id,
        ]);

        $age2 = DictionaryItem::create([
            'display_name' => ['uz' => '71 - 75', 'ru' => '71 - 75'],
            'dictionary_id' => $age->id,
        ]);

        $age3 = DictionaryItem::create([
            'display_name' => ['uz' => '76 - 85', 'ru' => '76 - 85'],
            'dictionary_id' => $age->id,
        ]);

        $age4 = DictionaryItem::create([
            'display_name' => ['uz' => '0 - 24', 'ru' => '0 - 24'],
            'dictionary_id' => $age->id,
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age1->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 66,
            'option_to' => 70,
            'value' => 2,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age2->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 71,
            'option_to' => 75,
            'value' => 3,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age3->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 76,
            'option_to' => 85,
            'value' => 10,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age4->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 0,
            'option_to' => 24,
            'value' => 0.8,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age1->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 66,
            'option_to' => 70,
            'value' => 2,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age2->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 71,
            'option_to' => 75,
            'value' => 3,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age3->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 76,
            'option_to' => 85,
            'value' => 10,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age4->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 0,
            'option_to' => 24,
            'value' => 0.8,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age1->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 66,
            'option_to' => 70,
            'value' => 2,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age2->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 71,
            'option_to' => 75,
            'value' => 3,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age3->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 76,
            'option_to' => 85,
            'value' => 10,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $age4->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 0,
            'option_to' => 24,
            'value' => 0.8,
            'status' => 1
        ]);

        // family
        $family = Dictionary::create([
            'name' => 'family',
            'display_name' => ['uz' => 'Oilaviy', 'ru' => 'Семейный'],
        ]);

        $family_item = DictionaryItem::create([
            'display_name' => ['uz' => 'Oilaviy', 'ru' => 'Семейный'],
            'dictionary_id' => $family->id,
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $family_item->id,
            'product_tariff_id' => $tariff1->id,
            'option_from' => 3,
            'option_to' => 5,
            'value' => 2.5,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $family_item->id,
            'product_tariff_id' => $tariff2->id,
            'option_from' => 3,
            'option_to' => 5,
            'value' => 2.5,
            'status' => 1
        ]);

        ProductTariffConfiguration::create([
            'dictionary_item_id' => $family_item->id,
            'product_tariff_id' => $tariff3->id,
            'option_from' => 3,
            'option_to' => 5,
            'value' => 2.5,
            'status' => 1
        ]);

        ProductTariffRisk::create([
            'product_tariff_id' => $tariff1->id,
            'name' => 'Медицинские издержки',
            'amount' => 8200
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff1->id,
            'name' => 'из них COVID-19 (ЛИМИТ)',
            'amount' => 0
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff1->id,
            'name' => 'Медицинская эвакуация',
            'amount' => 4000
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff1->id,
            'name' => 'Репатриация (транспортировка останков)',
            'amount' => 3000
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff1->id,
            'name' => 'Оплата сопровождающего',
            'amount' => 800
        ]);

        ProductTariffRisk::create([
            'product_tariff_id' => $tariff2->id,
            'name' => 'Медицинские издержки',
            'amount' => 29000
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff2->id,
            'name' => 'из них COVID-19 (ЛИМИТ)',
            'amount' => 0
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff2->id,
            'name' => 'Медицинская эвакуация',
            'amount' => 8000
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff2->id,
            'name' => 'Репатриация (транспортировка останков)',
            'amount' => 6000
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff2->id,
            'name' => 'Оплата сопровождающего',
            'amount' => 2000
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff3->id,
            'name' => 'Медицинские издержки',
            'amount' => 17000
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff3->id,
            'name' => 'из них COVID-19 (ЛИМИТ)',
            'amount' => 0
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff3->id,
            'name' => 'Медицинская эвакуация',
            'amount' => 8000
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff3->id,
            'name' => 'Репатриация (транспортировка останков)',
            'amount' => 7000
        ]);
        ProductTariffRisk::create([
            'product_tariff_id' => $tariff3->id,
            'name' => 'Оплата сопровождающего',
            'amount' => 1000
        ]);


        //osago

        $osago = ProductTariff::create([
            'name' => 'Osago' ,
            'description' => 'Osago description',
            'product_id' => '2',
            'status' => '1',
        ]);
        $autotype = Dictionary::create([
            'name' => 'autotype',
            'display_name' => ['uz' => 'Transport vositasining turi', 'ru' => 'Вид транспортного средства'],
        ]);
        $region = Dictionary::create([
            'name' => 'region',
            'display_name' => ['uz' => 'Avtotransport vositalarini ro\'yxatdan o\'tkazish mintaqasi', 'ru' => 'Регион регистрации транспортного средства'],
        ]);
        $period = Dictionary::create([
            'name' => 'period',
            'display_name' => ['uz' => 'Sug\'urta davri', 'ru' => 'Период страхования'],
        ]);
        $insurance_amount = Dictionary::create([
            'name' => 'insurance_amount',
            'display_name' => ['uz' => 'insurance amount', 'ru' => 'insurance amount'],
        ]);
        $pensioner = Dictionary::create([
            'name' => 'pensioner',
            'display_name' => ['uz' => 'nafaqa', 'ru' => 'pensioner'],
        ]);
        $insurance_amount_percent = Dictionary::create([
            'name' => 'insurance_amount_percent',
            'display_name' => ['uz' => 'insurance amount percent', 'ru' => 'insurance amount percent'],
        ]);
        $number_drivers = Dictionary::create([
            'name' => 'number_drivers',
            'display_name' => ['uz' => 'Haydovchilar soni', 'ru' => 'Количество водителей'],
        ]);
        $yengil = DictionaryItem::create([
            'display_name' => ['uz' => 'Yengil avtomobillar', 'ru' => 'Легковые автомобили'],
            'dictionary_id' => $autotype->id,
        ]);
        $yuk = DictionaryItem::create([
            'display_name' => ['uz' => 'Yuk avtomobillari', 'ru' => 'Грузовые автомобили'],
            'dictionary_id' => $autotype->id,
        ]);
        $avtobus = DictionaryItem::create([
            'display_name' => ['uz' => 'Avtobuslar va mikroavtobuslar', 'ru' => 'Автобус'],
            'dictionary_id' => $autotype->id,
        ]);
        $mototsikl = DictionaryItem::create([
            'display_name' => ['uz' => 'Mototsikllar va skuterlar', 'ru' => 'Мотоцикл'],
            'dictionary_id' => $autotype->id,
        ]);

        $tosh_city = DictionaryItem::create([
            'display_name' => ['uz' => 'Toshkent shahri va Toshkent viloyati', 'ru' => 'г.Ташкент и Ташкентская область'],
            'dictionary_id' => $region->id,
        ]);
        $other = DictionaryItem::create([
            'display_name' => ['uz' => 'Boshqa hududlar', 'ru' => 'Другие регионы'],
            'dictionary_id' => $region->id,
        ]);
        $year_1 = DictionaryItem::create([
            'display_name' => ['uz' => '1 yil', 'ru' => '1 год'],
            'dictionary_id' => $period->id,
        ]);
        $month_6 = DictionaryItem::create([
            'display_name' => ['uz' => '6 oy', 'ru' => '6 месяцев'],
            'dictionary_id' => $period->id,
        ]);
        $unlimited = DictionaryItem::create([
            'display_name' => ['uz' => 'Cheklanmagan', 'ru' => 'Не ограничено'],
            'dictionary_id' => $number_drivers->id,
        ]);
        $drivers_5 = DictionaryItem::create([
            'display_name' => ['uz' => '5 nafar haydovchigacha', 'ru' => 'Ограничено до 5 человек'],
            'dictionary_id' => $number_drivers->id,
        ]);
        $ins_amount = DictionaryItem::create([
            'name'=>'insurance_amount',
            'display_name' => ['uz' => 'insurance_amount', 'ru' => 'insurance_amount'],
            'dictionary_id' => $insurance_amount->id,
        ]);
        $ins_amount_percent = DictionaryItem::create([
            'name'=>'insurance_amount_percent',
            'display_name' => ['uz' => 'insurance_amount_percent', 'ru' => 'insurance_amount_percent'],
            'dictionary_id' => $insurance_amount_percent->id,
        ]);
        $is_pensioner = DictionaryItem::create([
            'name'=>'is_pensioner',
            'display_name' => ['uz' => 'nafaqa chegirmasi', 'ru' => 'pensioner skidka'],
            'dictionary_id' => $pensioner->id,
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $yengil->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 0.1,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $yuk->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 0.12,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $avtobus->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 0.12,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $mototsikl->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 0.04,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $tosh_city->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 1.4,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $other->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 1,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $year_1->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 1,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $month_6->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 0.7,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $unlimited->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 3,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $drivers_5->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 1,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $ins_amount->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 40000000,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $ins_amount_percent->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 1,
            'status' => 1
        ]);
        ProductTariffConfiguration::create([
            'dictionary_item_id' => $is_pensioner->id,
            'product_tariff_id' => $osago->id,
            'option_from' => 0,
            'option_to' => 0,
            'value' => 50,
            'status' => 1
        ]);
    }
}
