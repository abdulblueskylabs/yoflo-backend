<?php

  namespace Database\Seeders;

  use App\Models\NodeType;
  use Illuminate\Database\Console\Seeds\WithoutModelEvents;
  use Illuminate\Database\Seeder;

  class DatabaseSeeder extends Seeder
  {
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
      // \App\Models\User::factory(10)->create();
      $this->call(RolesTableSeeder::class);
      $this->call(SubscriptionTableSeeder::class);
      $this->call(AdminSeeder::class);
      $this->call(NodeTypeSeeder::class);
    }
  }
