<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\App;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(['email'=>'admin@school.com'],[
        'name'=>'Admin',
        'email'=>'admin@school.com',
        'password'=>Hash::make('password'),
        'role'=>'admin'
        ]);
        User::updateOrCreate(['email'=>'teacher@school.com'],[
            'name'=>'Teacher One',
            'email'=>'teacher@school.com',
            'password'=>Hash::make('password'),
            'role'=>'teacher'
        ]);
    }
}
