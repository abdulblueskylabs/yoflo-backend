<?php

  namespace Database\Seeders;

  use Illuminate\Database\Console\Seeds\WithoutModelEvents;
  use App\Models\NodeType;
  use Illuminate\Database\Seeder;

  class NodeTypeSeeder extends Seeder
  {
    /**
     * Run the database seeds.
     * @return void
     */
    public function run ()
    {
      //

      NodeType::create(
        [
          'name' => 'active',
        ]);
      NodeType::create(
        [
          'name' => 'link',
        ]);
      NodeType::create(
        [
          'name' => 'edge',
        ]);

    }
  }
