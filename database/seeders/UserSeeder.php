<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->insert([
			'name'=>'admin',
			'userid'=>'admin',
			'authtype'=>'admin',
			'password' => \Hash::make('12341234'),
		]);
		\DB::table('users')->insert([
			'name'=>'test',
			'userid'=>'test',
			'authtype'=>'member',
			'password' => \Hash::make('12341234'),
		]);
		\DB::table('users')->insert([
			'name'=>'default',
			'userid'=>'default',
			'authtype'=>'member',
			'password' => \Hash::make('12341234'),
		]);
		\DB::table('users')->insert([
			'name'=>'partner',
			'userid'=>'partner',
			'authtype'=>'partner',
			'password' => \Hash::make('12341234'),
		]);
    }
}