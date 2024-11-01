<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Country;

class CountriesTableSeeder extends Seeder
{
    public function run()
    {
        $countries = [
            ['name' => 'الولايات المتحدة', 'code' => 'US', 'flag' => 'https://flagcdn.com/us.svg', 'phone_code' => '+966'],
            ['name' => 'كندا', 'code' => 'CA', 'flag' => 'https://flagcdn.com/ca.svg', 'phone_code' => '+966'],
            ['name' => 'المملكة المتحدة', 'code' => 'GB', 'flag' => 'https://flagcdn.com/gb.svg', 'phone_code' => '+966'],
            ['name' => 'ألمانيا', 'code' => 'DE', 'flag' => 'https://flagcdn.com/de.svg', 'phone_code' => '+966'],
            ['name' => 'فرنسا', 'code' => 'FR', 'flag' => 'https://flagcdn.com/fr.svg', 'phone_code' => '+966'],
            ['name' => 'مصر', 'code' => 'EG', 'flag' => 'https://flagcdn.com/eg.svg', 'phone_code' => '+966'],
            ['name' => 'السعودية', 'code' => 'SA', 'flag' => 'https://flagcdn.com/sa.svg', 'phone_code' => '+966'],
            ['name' => 'الإمارات', 'code' => 'AE', 'flag' => 'https://flagcdn.com/ae.svg', 'phone_code' => '+966'],
            ['name' => 'الكويت', 'code' => 'KW', 'flag' => 'https://flagcdn.com/kw.svg', 'phone_code' => '+966'],
            ['name' => 'قطر', 'code' => 'QA', 'flag' => 'https://flagcdn.com/qa.svg', 'phone_code' => '+966'],
            ['name' => 'البحرين', 'code' => 'BH', 'flag' => 'https://flagcdn.com/bh.svg', 'phone_code' => '+966'],
            ['name' => 'عمان', 'code' => 'OM', 'flag' => 'https://flagcdn.com/om.svg', 'phone_code' => '+966'],
            ['name' => 'العراق', 'code' => 'IQ', 'flag' => 'https://flagcdn.com/iq.svg', 'phone_code' => '+966'],
            ['name' => 'الأردن', 'code' => 'JO', 'flag' => 'https://flagcdn.com/jo.svg', 'phone_code' => '+966'],
            ['name' => 'لبنان', 'code' => 'LB', 'flag' => 'https://flagcdn.com/lb.svg', 'phone_code' => '+966'],
            ['name' => 'سوريا', 'code' => 'SY', 'flag' => 'https://flagcdn.com/sy.svg', 'phone_code' => '+966'],
            ['name' => 'تونس', 'code' => 'TN', 'flag' => 'https://flagcdn.com/tn.svg', 'phone_code' => '+966'],
            ['name' => 'المغرب', 'code' => 'MA', 'flag' => 'https://flagcdn.com/ma.svg', 'phone_code' => '+966'],
            ['name' => 'الجزائر', 'code' => 'DZ', 'flag' => 'https://flagcdn.com/dz.svg', 'phone_code' => '+966'],
            // يمكنك إضافة المزيد من الدول هنا...
        ];

        Country::insert($countries);
    }
}
