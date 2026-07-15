<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['setting_key' => 'app_name', 'setting_value' => '3D-LTP', 'setting_type' => 'string', 'description' => 'Application name'],
            ['setting_key' => 'app_email', 'setting_value' => 'admin@tutorplatform.com', 'setting_type' => 'string', 'description' => 'Application email'],
            ['setting_key' => 'app_phone', 'setting_value' => '+1234567890', 'setting_type' => 'string', 'description' => 'Application phone number'],
            ['setting_key' => 'timezone', 'setting_value' => 'UTC', 'setting_type' => 'string', 'description' => 'Application timezone'],
            ['setting_key' => 'sessions_per_week', 'setting_value' => '3', 'setting_type' => 'integer', 'description' => 'Default sessions per week'],
            ['setting_key' => 'session_duration', 'setting_value' => '60', 'setting_type' => 'integer', 'description' => 'Default session duration in minutes'],
            ['setting_key' => 'enable_google_meet', 'setting_value' => '1', 'setting_type' => 'boolean', 'description' => 'Enable Google Meet integration'],
            ['setting_key' => 'enable_notifications', 'setting_value' => '1', 'setting_type' => 'boolean', 'description' => 'Enable notifications'],
            ['setting_key' => 'enable_email', 'setting_value' => '1', 'setting_type' => 'boolean', 'description' => 'Enable email notifications'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::firstOrCreate(
                ['setting_key' => $setting['setting_key']],
                $setting
            );
        }
    }
}
