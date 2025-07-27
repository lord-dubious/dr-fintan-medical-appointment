<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Seed the site settings.
     */
    public function run(): void
    {
        $defaultSettings = [
            ['key'=>'site_name', 'value'=>'Dr. Fintan Medical Appointment', 'type'=>'text', 'group_name'=>'general', 'label'=>'Site Name'],
            ['key'=>'site_tagline', 'value'=>'Your Health, Our Priority', 'type'=>'text', 'group_name'=>'general', 'label'=>'Site Tagline'],
            ['key'=>'site_description', 'value'=>'Professional medical consultation and appointment booking system', 'type'=>'textarea', 'group_name'=>'general', 'label'=>'Site Description'],
            ['key'=>'contact_phone', 'value'=>'+1 (555) 123-4567', 'type'=>'text', 'group_name'=>'contact', 'label'=>'Phone Number'],
            ['key'=>'contact_email', 'value'=>'info@drfintan.com', 'type'=>'text', 'group_name'=>'contact', 'label'=>'Email Address'],
            ['key'=>'contact_address', 'value'=>'123 Medical Center Dr, Health City, HC 12345', 'type'=>'textarea', 'group_name'=>'contact', 'label'=>'Address'],
            ['key'=>'office_hours', 'value'=>"Mon-Fri: 9:00 AM - 6:00 PM\nSat: 9:00 AM - 2:00 PM\nSun: Closed", 'type'=>'textarea', 'group_name'=>'contact', 'label'=>'Office Hours'],
            ['key'=>'social_facebook', 'value'=>'', 'type'=>'text', 'group_name'=>'social', 'label'=>'Facebook URL'],
            ['key'=>'social_twitter', 'value'=>'', 'type'=>'text', 'group_name'=>'social', 'label'=>'Twitter URL'],
            ['key'=>'social_linkedin', 'value'=>'', 'type'=>'text', 'group_name'=>'social', 'label'=>'LinkedIn URL'],
            ['key'=>'social_instagram', 'value'=>'', 'type'=>'text', 'group_name'=>'social', 'label'=>'Instagram URL'],
            ['key'=>'hero_image', 'value'=>'', 'type'=>'image', 'group_name'=>'appearance', 'label'=>'Hero Image'],
            ['key'=>'doctor_profile_image', 'value'=>'', 'type'=>'image', 'group_name'=>'appearance', 'label'=>'Doctor Profile Image'],
        ];

        foreach ($defaultSettings as $setting) {
            SiteSetting::firstOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'group_name' => $setting['group_name'],
                    'label' => $setting['label'],
                    'description' => $setting['description'] ?? null,
                ]
            );
        }
    }
}
