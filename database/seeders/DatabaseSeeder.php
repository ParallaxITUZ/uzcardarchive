<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        $this->call(FileSeeder::class);
        $this->call(DictionarySeeder::class);
        $this->call(OrganizationSeeder::class);
        $this->call(PolicySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(WarehouseSeeder::class);
        $this->call(PolicyRequestSeeder::class);
        $this->call(ClientContractSeeder::class);
        $this->call(RelativeSeeder::class);
        $this->call(ReContractReasonSeeder::class);
    }
}
