<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            ['name' => 'الإنجليزية', 'code' => 'en'],
            ['name' => 'العربية', 'code' => 'ar'],
        ];

        Language::insert($languages);
    }
}
