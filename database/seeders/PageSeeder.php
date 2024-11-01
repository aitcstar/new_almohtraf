<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\pages;

class PageSeeder extends Seeder
{
    public function run()
    {
        pages::create(['id' => 1 ,'key' => 'site.terms','value' => '  ']);
        pages::create(['id' => 2 ,'key' => 'site.privacy','value' => ' ']);
        pages::create(['id' => 3 ,'key' => 'site.fees','value' => ' ']);
    }
}
