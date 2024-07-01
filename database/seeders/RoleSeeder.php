<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::get()->count();

        if($roles < 1) {
            $data = [
                [
                    'name' => 'Super Admin',
                    'created_at' => now()
                ],
                [
                    'name' => 'Engineer',
                    'created_at' => now()
                ],
            ];

            $roleSeed = Role::insert($data);
        }
    }
}
