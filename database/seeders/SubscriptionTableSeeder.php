<?php

  namespace Database\Seeders;

  use App\Models\Subscription;
  use Illuminate\Database\Console\Seeds\WithoutModelEvents;
  use Illuminate\Database\Seeder;

  class SubscriptionTableSeeder extends Seeder
  {
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
      // create default subscriptions packages
      Subscription::create([
        'name' => 'Basic',
        'max_node_quantity' => 20,
        'max_share_quantity' => 0,
        'max_storage_quantity' => 1.5,
        'cost' => 0.0,
        'is_active' => 1,
      ]);
      Subscription::create([
        'name' => 'Silver',
        'max_node_quantity' => 400,
        'max_share_quantity' => 20,
        'max_storage_quantity' => 40,
        'cost' => 10.0,
        'is_active' => 1,
      ]);

      Subscription::create([
        'name' => 'Gold',
        'max_node_quantity' => 800,
        'max_share_quantity' => 30,
        'max_storage_quantity' => 80,
        'cost' => 20.0,
        'is_active' => 1,
      ]);
      Subscription::create([
        'name' => 'Platinum',
        'max_node_quantity' => 0,
        'max_share_quantity' => 40,
        'max_storage_quantity' => 140 ,
        'cost' => 30.0,
        'is_active' => 1,
      ]);

    }
  }
