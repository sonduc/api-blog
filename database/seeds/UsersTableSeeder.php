<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if (!DB::table('users')->find(1)) {
            DB::table('users')->insert([
	            'user_name' => 'admin',
	            'email' 	=> 'admin@gmail.com',
	            'password'  => bcrypt('123456'),
        	]);
        }
    }
}
