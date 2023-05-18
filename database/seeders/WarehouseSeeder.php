<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Policy;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Warehouse::query()->create([
            'id' => Warehouse::FOND,
            'organization_id' => Organization::FOND
        ]);
        WarehouseItem::query()->create([
            'id' => WarehouseItem::FOND,
            'warehouse_id' => Warehouse::FOND,
            'policy_id' => Policy::FOND,
            'series' => Policy::FOND_SERIES,
            'number_from' => 0,
            'number_to' => 1,
            'amount' => 1,
        ]);
        $warehouse = Warehouse::query()->create([
            'organization_id' => Organization::KAFOLAT
        ]);
        $from = 1;
        $to = 10000;
        $amount = 10000;
        for ($i = 0; $i < 5; $i++){
            WarehouseItem::query()->create([
                'warehouse_id' => $warehouse->id,
                'policy_id' => 2,
                'series' => 'EKFL',
                'number_from' => $from,
                'number_to' => $to,
                'amount' => $amount,
            ]);
            $from = $from+$amount;
            $to = $to+$amount;
        }
        $organizations = Organization::query()
            ->where('id', '<>', Organization::FOND)
            ->where('id', '<>', Organization::KAFOLAT)
            ->get();
        foreach ($organizations as $organization){
            Warehouse::query()->create([
                'organization_id' => $organization->id
            ]);
        }
    }
}
