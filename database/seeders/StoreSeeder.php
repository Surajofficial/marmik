<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Store::create([
            'clinic_name' => 'AWISH CLINIC',
            'address' => 'J-232, Pocket J, Sarita Vihar, New Delhi, Delhi 110076',
            'star_rating' => 5
        ]);
    
        Store::create([
            'clinic_name' => 'AWISH CLINIC',
            'address' => '5/30, Upper Ground Floor, Street Side, Block 6, West Patel Nagar, Patel Nagar, New Delhi, Delhi, 110008',
            'star_rating' => 4
        ]);
    
        Store::create([
            'clinic_name' => 'AWISH SKIN HAIR LASER PLASTIC SURGERY CLINIC',
            'address' => '694/31, 694, near Govt. Model Sanskriti Primary School, Sector 31, Gurugram, Haryana 122001',
            'star_rating' => 4
        ]);
    }
}
