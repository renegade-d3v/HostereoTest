<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = [
            ['locale' => 'ua', 'prefix' => 'ua'],
            ['locale' => 'ru', 'prefix' => 'ru'],
            ['locale' => 'en', 'prefix' => 'en'],
        ];

        DB::table('languages')->insert($locales);
    }
}
