<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RevenueCategory;
use Illuminate\Support\Facades\DB;

class RevenueItemSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Property Rates' => ['Residential Property Rate', 'Commercial Property Rate', 'Industrial Property Rate'],
            'Business Levy' => ['Small Business Levy', 'Medium Business Levy', 'Large Business Levy'],
            'Trading License Fees' => ['General Trading License', 'Mobile Trading License', 'Seasonal Trading License'],
            'Market Levies' => ['Daily Stall Fee', 'Weekly Stall Fee', 'Monthly Stall Fee'],
            'Bus Station Fees' => ['Bus Entry Fee', 'Overnight Parking Fee', 'Passenger Loading Fee'],
            'Parking Fees' => ['On Street Parking', 'Off Street Parking', 'Reserved Parking'],
            'Land Rates' => ['Urban Land Rate', 'Agricultural Land Rate', 'Commercial Land Rate'],
            'Building Plan Approval Fees' => ['Residential Plan Approval', 'Commercial Plan Approval', 'Industrial Plan Approval'],
            'Waste Management Fees' => ['Domestic Waste Collection', 'Commercial Waste Collection', 'Industrial Waste Collection'],
            'Advertising and Billboard Fees' => ['Roadside Billboard Fee', 'Wall Mounted Advertisement', 'Temporary Advertisement Permit'],
            'Health Inspection Fees' => ['Food Premises Inspection', 'Health Clearance Certificate', 'Medical Fitness Certificate'],
            'Liquor Licensing Fees' => ['Tavern License', 'Nightclub License', 'Restaurant Liquor License'],
            'Environmental Protection Fees' => ['Environmental Impact Assessment', 'Pollution Control Permit', 'Waste Disposal Permit'],
            'Road User Fees' => ['Heavy Vehicle Road Fee', 'Light Vehicle Road Fee', 'Permit for Abnormal Loads'],
            'Mining and Quarry Fees' => ['Quarry Operating License', 'Sand Mining Permit', 'Stone Crushing Permit'],
            'Fisheries and Wildlife Permits' => ['Fishing Permit', 'Fish Trading License', 'Wildlife Permit'],
            'Fire Safety Inspection Fees' => ['Fire Clearance Certificate', 'Fire Equipment Inspection'],
            'Cemetery and Burial Fees' => ['Burial Permit', 'Grave Reservation Fee'],
        ];

        foreach ($data as $catName => $items) {
            $category = RevenueCategory::where('name', $catName)->first();
            if ($category) {
                foreach ($items as $itemName) {
                    DB::table('revenue_items')->updateOrInsert(
                        ['name' => $itemName],
                        [
                            'category_id' => $category->id,
                            'code' => strtoupper(substr(str_replace(' ', '_', $itemName), 0, 10)),
                            'description' => $itemName . ' collection item',
                            'calculation_type' => 'fixed',
                            'amount' => 100.00,
                            'payment_frequency' => 'annual',
                            'penalty_rate' => 0.10,
                            'is_active' => true,
                            'created_by' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }
    }
}