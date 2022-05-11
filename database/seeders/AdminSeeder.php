<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = User::create([
        'first_name' => 'Admin',
        'last_name' => 'yoflo',
        'email' => 'admin@gmail.com',
        'phone' => '045111111',
        'is_active' => 1,
        'password' => Hash::make('admin')
      ]);
      $user->assignRole('admin');
    }
}
