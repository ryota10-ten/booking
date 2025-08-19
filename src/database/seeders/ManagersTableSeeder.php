<?php

namespace Database\Seeders;

use App\Models\Manager;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurantIds = Restaurant::pluck('id');
        foreach ($restaurantIds as $id) {
            Manager::create([
                'name' => 'Manager ' . $id,
                'email' => 'manager' . $id . '@example.com',
                'password' => Hash::make('testtest'),
            ]);
        }
    }
}
