<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\GasUser;
use App\Models\IcecreamUser;
use App\Models\Role;
use App\Models\WatercomUser;
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
                GasUser::create(
                    [
                        'name' => 'Gas Admin',
                        'status' => true,
                        'role_id' => 1,
                        'email' => 'admin@gas.com',
                        'password' => bcrypt('12312345'),
                    ],
                ),
                IcecreamUser::create(
                    [
                        'name' => 'Icecream Admin',
                        'status' => true,
                        'role_id' => 1,
                        'email' => 'admin@icecream.com',
                        'password' => bcrypt('12312345'),
                    ],
                ),
                WatercomUser::create(
                    [
                        'name' => 'Watercom Admin',
                        'status' => true,
                        'role_id' => 1,
                        'email' => 'admin@watercom.com',
                        'password' => bcrypt('12312345'),
                    ],
                ),
            ]
        );
        Role::where('name', Role::CASHIER)->first()->save(
            [
                GasUser::create(
                    [
                        'name' => 'Gas Cashier',
                        'status' => true,
                        'role_id' => 2,
                        'email' => 'cashier@gas.com',
                        'password' => bcrypt('12312345'),
                    ],
                ),
                IcecreamUser::create(
                    [
                        'name' => 'Icecream Cashier',
                        'status' => true,
                        'role_id' => 2,
                        'email' => 'cashier@icecream.com',
                        'password' => bcrypt('12312345'),
                    ],
                ),
                WatercomUser::create(
                    [
                        'name' => 'Watercom Cashier',
                        'status' => true,
                        'role_id' => 2,
                        'email' => 'cashier@watercom.com',
                        'password' => bcrypt('12312345'),
                    ],
                ),
            ]
        );
    }
}
