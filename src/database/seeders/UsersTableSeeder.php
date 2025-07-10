<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'test1',
            'email' => 'test1@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('testtest'),
        ];
        User::create($param);

        $param = [
            'name' => 'test2',
            'email' => 'test2@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('testtest'),
        ];
        User::create($param);
    }
}
