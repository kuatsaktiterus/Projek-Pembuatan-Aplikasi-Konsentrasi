<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin::create([
            'id'        => '1',
            'nama'      => 'Admin 1',
            'id_user'   => 4,
    ]);
    }
}
