<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get()->count();
        if($users < 1) {
            $data = [
                [
                    'name' => 'Md. Zahin Hossain',
                    'email' => 'zahin.sbf@gmail.com',
                    'password' => bcrypt('12345678'),
                    'center_id' => 20,
                    'created_at' => now(),
                    'role_id' => 1,
                    'up_for_more' => 1,
                    'score' => 0
                ],
                [
                    'name' => 'Abu Hena M Kamal',
                    'email' => 'ishmam@comcast.com',
                    'password' => bcrypt('12345678'),
                    'center_id' => 20,
                    'created_at' => now(),
                    'role_id' => 1,
                    'up_for_more' => 1,
                    'score' => 0
                ]
            ];

            $userSeed = User::insert($data);
        }
    }
}
