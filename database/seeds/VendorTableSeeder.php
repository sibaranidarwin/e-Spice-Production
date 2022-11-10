<?php

use Illuminate\Database\Seeder;
use App\VendorID;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        VendorID::create([
            'vendor_name' => 'United Tractors',
            'vendor_address' => 'Jakarta Selatan',
            'logo' => 'unitedtractors.png',
        ]);
    }
}
