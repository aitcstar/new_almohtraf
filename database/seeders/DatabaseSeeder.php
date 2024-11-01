<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Setting;
class DatabaseSeeder extends Seeder
{
    public function run()
    {

        Role::create(['id' => 1 ,'name' => 'admin']);
        Role::create(['id' => 2 ,'name' => 'user']);
        User::create([
                'firstname' => "Super",
                'familyname' => "Admin",
                'email' => "admin@admin.com",
                'password' => bcrypt('12345678'),
                'role_id' => 1,
        ]);
        Setting::insert([
            [
                'key' => "site.title",
                'value' => "",
            ],
            [
                'key' => "site.description",
                'value' => "",
            ],
            [
                'key' => "site.keywords",
                'value' => "",
            ],
            [
                'key' => "site.phone",
                'value' => "",
            ],
            [
                'key' => "site.phoneother",
                'value' => "",
            ],
            [
                'key' => "site.whatsapp",
                'value' => "",
            ],
            [
                'key' => "site.email",
                'value' => "",
            ],
            [
                'key' => "site.address",
                'value' => "",
            ],
            [
                'key' => "site.logo",
                'value' => "logo/1618845055.png",
            ],
            [
                'key' => "site.shorabout",
                'value' => "",
            ]

        ]);
    }
}
