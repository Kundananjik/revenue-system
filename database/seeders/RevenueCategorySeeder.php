<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RevenueCategorySeeder extends Seeder
{
public function run(): void
{
    $this->call([
        RevenueCategorySeeder::class,
    ]);
        DB::table('revenue_categories')->insert([
            [
                'name' => 'Local Taxes/Rates',
                'slug' => 'local-taxes',
                'description' => 'Property rates, land taxes',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fees and Charges',
                'slug' => 'fees-charges',
                'description' => 'Service fees (waste, parking)',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Licenses',
                'slug' => 'licenses',
                'description' => 'Business and liquor licenses',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Permits',
                'slug' => 'permits',
                'description' => 'Construction, events permits',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Charges',
                'slug' => 'charges',
                'description' => 'Penalties and admin charges',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Other Income',
                'slug' => 'other-income',
                'description' => 'Rent, grants, miscellaneous',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
