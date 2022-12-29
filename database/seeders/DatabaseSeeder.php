<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'name' => Role::ADMIN,
                'status' => true,
                'description' => 'A system administrator',
            ],
            [
                'name' => Role::CASHIER,
                'status' => true,
                'description' => 'A system cashier',
            ],
        ])->each(function ($role) {
            Role::create($role);
        });

        Role::where('name', Role::ADMIN)->first()->save(
            [
                User::factory()->create(
                    [
                        'name' => 'Test Admin',
                        'status' => true,
                        'role_id' => 1,
                        'email' => 'admin@test.com',
                        'password' => bcrypt('12312345'),
                    ],
                )

            ]
        );
        Role::where('name', Role::CASHIER)->first()->save(
            [
                User::factory()->create(
                    [
                        'name' => 'Test Cashier',
                        'status' => true,
                        'role_id' => 2,
                        'email' => 'cashier@test.com',
                        'password' => bcrypt('12312345'),
                    ],
                )
            ]
        );
    }
}
