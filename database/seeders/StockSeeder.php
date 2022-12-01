<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Stock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('stocks')->count() == 0){

            DB::table('stocks')->insert([
            ['name' => 'Beef', 'capacity' => '20000' ,'used_capacity' => 0 ,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Cheese', 'capacity' => '5000' ,'used_capacity' => 0 ,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Onion', 'capacity' => '1000' ,'used_capacity' => 0 ,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

        ]);

        } else { echo "\e[31mTable is not empty"; }

    }
}
