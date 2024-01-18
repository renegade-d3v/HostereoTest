<?php

namespace Database\Seeders;

use App\Models\PostTranslation;
use Illuminate\Database\Seeder;

class PostTranslateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostTranslation::factory(50)->create();
    }
}
