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

      Role::create(
        [
          'name' => 'active',
        ]);
      Role::create(
        [
          'name' => 'link',
        ]);
      Role::create(
        [
          'name' => 'edge',
        ]);

    }
  }
