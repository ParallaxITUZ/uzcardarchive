<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Policy;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Policy::query()->create([
            'id' => Policy::FOND,
            'display_name' => [
                'uz' => 'FOND',
                'ru' => 'FOND'
            ],
            'series' => Policy::FOND_SERIES,
            'form' => 1,
            'status' => Policy::STATUS_ACTIVE,
        ]);
        Policy::query()->create([
            'display_name' => [
                'uz' => 'Travel',
                'ru' => 'Travel'
            ],
            'series' => 'CN-UZ',
            'form' => 1,
            'status' => Policy::STATUS_ACTIVE,
        ]);
        Policy::query()->create([
            'display_name' => [
                'uz' => 'Osaga',
                'ru' => 'Osaga'
            ],
            'series' => 'EKFL',
            'form' => 1,
            'status' => Policy::STATUS_ACTIVE,
        ]);
    }
}
