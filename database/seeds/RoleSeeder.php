<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('roles')->find(1)) {
            DB::table('roles')->insert([
                'name'        => 'Super admin',
                'slug'        => 'superadmin',
                'permissions' => json_encode([
                    'admin.super-admin' => true,
                ]),
            ]);
        }

        if (!DB::table('roles')->find(2)) {
            DB::table('roles')->insert([
                'name'        => 'Supporter',
                'slug'        => 'supporter',
                'permissions' => json_encode([
                    "category.view"                 => true,
                    "category.create"               => true,
                    "category.update"               => true,
                    "category.delete"               => true,
                ]),
            ]);
        }
    }
}
