<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::truncate();
        Setting::create([
            'website_name' => "Beej Bhandar",
            'from_mail_name' => "Amit Beej Bhandar",
            'from_mail_address' => "info@amitbeejbhandar.com",
        ]);
    }
}
