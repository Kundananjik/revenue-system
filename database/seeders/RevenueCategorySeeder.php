<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RevenueCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Property Rates',
                'slug' => 'property-rates',
                'description' => 'Property rates collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Business Levy',
                'slug' => 'business-levy',
                'description' => 'Business levy collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Trading License Fees',
                'slug' => 'trading-license-fees',
                'description' => 'Trading License Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Market Levies',
                'slug' => 'market-levies',
                'description' => 'Market Levies collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Bus Station Fees',
                'slug' => 'bus-station-fees',
                'description' => 'Bus Station Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Parking Fees',
                'slug' => 'parking-fees',
                'description' => 'Parking Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Land Rates',
                'slug' => 'land-rates',
                'description' => 'Land Rates collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Building Plan Approval Fees',
                'slug' => 'building-plan-approval-fees',
                'description' => 'Building Plan Approval Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Waste Management Fees',
                'slug' => 'waste-management-fees',
                'description' => 'Waste Management Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Advertising and Billboard Fees',
                'slug' => 'advertising-and-billboard-fees',
                'description' => 'Advertising and Billboard Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Health Inspection Fees',
                'slug' => 'health-inspection-fees',
                'description' => 'Health Inspection Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Liquor Licensing Fees',
                'slug' => 'liquor-licensing-fees',
                'description' => 'Liquor Licensing Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Environmental Protection Fees',
                'slug' => 'environmental-protection-fees',
                'description' => 'Environmental Protection Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Road User Fees',
                'slug' => 'road-user-fees',
                'description' => 'Road User Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Mining and Quarry Fees',
                'slug' => 'mining-and-quarry-fees',
                'description' => 'Mining and Quarry Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Fisheries and Wildlife Permits',
                'slug' => 'fisheries-and-wildlife-permits',
                'description' => 'Fisheries and Wildlife Permits collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Fire Safety Inspection Fees',
                'slug' => 'fire-safety-inspection-fees',
                'description' => 'Fire Safety Inspection Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
            [
                'name' => 'Cemetery and Burial Fees',
                'slug' => 'cemetery-and-burial-fees',
                'description' => 'Cemetery and Burial Fees collected by local authorities',
                'is_active' => true,
                'created_by' => null,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('revenue_categories')->updateOrInsert(
                ['name' => $category['name']], // unique column to check
                array_merge($category, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
