<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SupplierMaster;
use App\Models\UnitType;
use Database\Factories\ProductFactory;
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
        Product::factory(10)->create();
        Customer::factory(3)->create();
        SupplierMaster::factory(3)->create();
        $this->call(AdminSeederTable::class);
        $this->call(SettingSeederTable::class);

        UnitType::updateOrCreate(['id' => 1],['name' => 'All']);
        ProductCategory::updateOrCreate(['id' => 1],['name' => 'All']);
    }
}
