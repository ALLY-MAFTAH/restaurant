<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'name' => Role::ADMIN,
                'description' => 'A system administrator',
            ],
            [
                'name' => Role::CASHIER,
                'description' => 'A restaurant cashier',
            ],
        ])->each(function ($role) {
            Role::create($role);
        });
    }
}
