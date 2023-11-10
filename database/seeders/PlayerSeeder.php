<?php

namespace Database\Seeders;

use App\Models\PlayerSkill;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        PlayerSkill::factory(5)->create();
    }
}
