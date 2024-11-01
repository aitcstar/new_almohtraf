<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectProgress;

class ProjectProgressSeeder extends Seeder
{
    public function run()
    {
        ProjectProgress::create(['id' => 1 ,'name' => 'مرحلة تلقي العروض']);
        ProjectProgress::create(['id' => 2 ,'name' => 'مرحلة التنفيذ']);
        ProjectProgress::create(['id' => 3 ,'name' => 'مرحلة التسليم']);
    }
}
