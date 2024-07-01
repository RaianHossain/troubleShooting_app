<?php

namespace Database\Seeders;

use App\Models\Center;
use Illuminate\Database\Seeder;

class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $centers = Center::get()->count();

        if($centers < 1) {
            $data = [
                [
                    'name' => 'SBFCKCC',
                    'city' => 'Dhaka',
                    'concern_person' => 'Md. Sharifur Rahman',
                    'created_at' => now()
                ],
                [
                    'name' => 'Afzalia Estate',
                    'city' => 'Rangpur',
                    'concern_person' => 'Md. Asrar Hossain',
                    'created_at' => now()
                ],
                [
                    'name' => 'ISKKC',
                    'city' => 'Bagura',
                    'concern_person' => 'Md. Shah Alam',
                    'created_at' => now()
                ],
                [
                    'name' => 'ISKKC',
                    'city' => 'Dinajpur',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'ISK Foundation-Afzalia Estate Kidney Center',
                    'city' => 'Khulna',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'ISKKC',
                    'city' => 'Kushtia',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'Afzalia Estate',
                    'city' => 'Moulovibazar',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'ISKKC',
                    'city' => 'Rajshahi',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'Afzalia Estate-SBF Kidney Dialysis Center',
                    'city' => 'Jashore',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'SBF Houston Kidney Dialysis Center',
                    'city' => 'Narsingdi',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'Afzalia Estate-SBF Kidney Dialysis Center',
                    'city' => 'Patuakhali',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'SBF Ohio Kidney Dialysis Center',
                    'city' => 'Noakhali',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'ISKKDC',
                    'city' => 'Jamalpur',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'Arizona Kidney Dialysis Center',
                    'city' => 'Faridpur',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'SBF AMAN Foundation Health Center',
                    'city' => 'Keraniganj',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'NCC-SBF Kidney Dialysis Center',
                    'city' => 'Narayanganj',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'SBF Nazir Ahmed-Shamsul Haq Kidney Dialysis Center',
                    'city' => 'Jatrabari',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'SBF-Sacramento Kidney Dialysis Center',
                    'city' => 'Gazipur',
                    'concern_person' => 'Need to update',
                    'created_at' => now()
                ],
                [
                    'name' => 'SBF R&D Center',
                    'city' => 'Kaliakoir',
                    'concern_person' => 'Md. Zahin Hossain',
                    'created_at' => now()
                ],
                
            ];

            $centersSeed = Center::insert($data);
        }
    }
}
