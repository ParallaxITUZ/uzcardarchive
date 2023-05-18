<?php

namespace Database\Seeders;

use App\Models\Dictionary;
use App\Models\DictionaryItem;
use Illuminate\Database\Seeder;

class DictionarySeeder extends Seeder
{
    /**
     * Runs the database seeds for adding rows to dictionaries table
     *
     * @return void
     */
    public function run()
    {
        $this->seedRegions();
        $this->seedEntityTypes();
        $this->seedOrganizationalStructures();
        $this->seedPositions();
        $this->seedAgentTypes();
    }

    /**
     * Adds Region rows to dictionaries table
     */
    protected function seedRegions(){
        $dictionary = Dictionary::create([
            'name' => 'regions',
            'display_name' => ['uz' => 'Hududlar', 'ru' => 'Регионы'],
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Andijon viloyati', 'ru' => 'Андижанская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Farg\'ona viloyati', 'ru' => 'Ферганская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Namangan viloyati', 'ru' => 'Наманганская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Sirdaryo viloyati', 'ru' => 'Сырдарьинская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Jizzax viloyati', 'ru' => 'Джизакская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Navoiy viloyati', 'ru' => 'Навоийская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Samarqand viloyati', 'ru' => 'Самаркандская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Buxoro viloyati', 'ru' => 'Бухарская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Qashqadaryo viloyati', 'ru' => 'Кашкадарьинская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Surxandaryo viloyati', 'ru' => 'Сурхандарьинская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Xorazm viloyati', 'ru' => 'Хорезмская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Qoraqalpog\'iston Respublikasi', 'ru' => 'Республика Каракалпакстан'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Toshkent viloyati', 'ru' => 'Ташкентская область'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Toshkent shahri', 'ru' => 'Город Ташкент'],
            'dictionary_id' => $dictionary->id,
        ]);
    }

    /**
     * Adds Entity type rows to dictionaries table
     */
    protected function seedEntityTypes(){
        $dictionary = Dictionary::create([
            'name' => 'entity_types',
            'display_name' => ['uz' => 'Subekt turlari', 'ru' => 'Типы субектов'],
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Jismoniy shaxs', 'ru' => 'Физическое лицо'],
            'dictionary_id' => $dictionary->id,
            'name' => 'individual',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Yuridik shaxs', 'ru' => 'Юридическое лицо'],
            'dictionary_id' => $dictionary->id,
            'name' => 'legal',
        ]);
    }

    /**
     * Adds Organizational structure type rows to dictionaries table
     */
    protected function seedOrganizationalStructures(){
        $dictionary = Dictionary::create([
            'name' => 'organizational_structures',
            'display_name' => ['uz' => 'Tashkiliy tuzilmalar', 'ru' => 'Организационные структуры'],
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Kompaniya', 'ru' => 'Компания'],
            'dictionary_id' => $dictionary->id,
            'name' => 'company',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Filial', 'ru' => 'Филиал'],
            'dictionary_id' => $dictionary->id,
            'name' => 'filial',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Markaz', 'ru' => 'Центр'],
            'dictionary_id' => $dictionary->id,
            'name' => 'centre',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Bo\'lim', 'ru' => 'Отделение'],
            'dictionary_id' => $dictionary->id,
            'name' => 'department',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Agent', 'ru' => 'Агент'],
            'dictionary_id' => $dictionary->id,
            'name' => 'agent',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Korhona hodimi', 'ru' => 'Работник компании'],
            'dictionary_id' => $dictionary->id,
            'name' => 'company_worker',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Agent hodimi (Sub agent)', 'ru' => 'Работник агента'],
            'dictionary_id' => $dictionary->id,
            'name' => 'sub_agent',
        ]);
    }

    /**
     * Adds Position rows to dictionaries table
     */
    protected function seedPositions(){
        $dictionary = Dictionary::create([
            'name' => 'positions',
            'display_name' => ['uz' => 'Lavozimlar', 'ru' => 'Позиции'],
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Director', 'ru' => 'Директор'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Menejer', 'ru' => 'Менеджер'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Agent', 'ru' => 'Агент'],
            'dictionary_id' => $dictionary->id,
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Hodim', 'ru' => 'Работник'],
            'dictionary_id' => $dictionary->id,
        ]);
    }

    /**
     * Adds Agent type rows to dictionaries table
     */
    protected function seedAgentTypes(){
        $dictionary = Dictionary::create([
            'name' => 'agent_types',
            'display_name' => ['uz' => 'Web turlari', 'ru' => 'Типы агентов'],
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Jismoniy shaxs', 'ru' => 'Физическое лицо'],
            'dictionary_id' => $dictionary->id,
            'name' => 'agent_type_fiz',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Yuridik shaxs', 'ru' => 'Юридическое лицо'],
            'dictionary_id' => $dictionary->id,
            'name' => 'agent_type_yur',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Korhona hodimi', 'ru' => 'Работник компании'],
            'dictionary_id' => $dictionary->id,
            'name' => 'agent_type_company',
        ]);
        DictionaryItem::create([
            'display_name' => ['uz' => 'Agent hodimi', 'ru' => 'Работник агента'],
            'dictionary_id' => $dictionary->id,
            'name' => 'agent_type_sub',
        ]);
    }
}
