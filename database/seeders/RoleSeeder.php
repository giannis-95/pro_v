<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::create([
            'name' => 'Διαχειριστής',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'Φοιτητής',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'Καθηγητής',
            'guard_name' => 'web',
        ]);
    }
}
