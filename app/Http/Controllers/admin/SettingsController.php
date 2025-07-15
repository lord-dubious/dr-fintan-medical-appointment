<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Show settings management page
     */
    public function index()
    {
        $settingGroups = [
            'general' => 'General Settings',
            'contact' => 'Contact Information',
            'social' => 'Social Media',
            'appearance' => 'Appearance',
            'seo' => 'SEO Settings',
        ];

        $settings = SiteSetting::where('is_active', true)
            ->orderBy('group_name')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('group_name');

        return view('admin.settings.index', compact('settingGroups', 'settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->settings as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully!',
        ]);
    }

    /**
     * Upload setting image
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'setting_key' => 'required|string',
        ]);

        $settingKey = $request->setting_key;
        $disk = config('filesystems.default');
        /** @var Cloud|Filesystem $storage */
        $storage = Storage::disk($disk);

        // Delete old image if exists
        $oldSetting = SiteSetting::where('key', $settingKey)->first();
        if ($oldSetting && $oldSetting->value) {
            $storage->delete($oldSetting->value);
        }

        // Store new image
        $imagePath = $request->file('image')->store('settings', $disk);

        SiteSetting::set($settingKey, $imagePath, 'image');

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully!',
            'image_url' => $storage->url($imagePath),
        ]);
    }

    /**
     * Get setting value
     */
    public function getSetting($key)
    {
        $value = SiteSetting::get($key);

        return response()->json([
            'success' => true,
            'value' => $value,
        ]);
    }

    /**
     * Initialize default settings
     */
    public function initializeDefaults()
    {
        $defaultSettings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'Dr. Fintan Medical Appointment', 'type' => 'text', 'group_name' => 'general', 'label' => 'Site Name'],
            ['key' => 'site_tagline', 'value' => 'Your Health, Our Priority', 'type' => 'text', 'group_name' => 'general', 'label' => 'Site Tagline'],
            ['key' => 'site_description', 'value' => 'Professional medical consultation and appointment booking system', 'type' => 'textarea', 'group_name' => 'general', 'label' => 'Site Description'],

            // Contact Information
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'type' => 'text', 'group_name' => 'contact', 'label' => 'Phone Number'],
            ['key' => 'contact_email', 'value' => 'info@drfintan.com', 'type' => 'text', 'group_name' => 'contact', 'label' => 'Email Address'],
            ['key' => 'contact_address', 'value' => '123 Medical Center Dr, Health City, HC 12345', 'type' => 'textarea', 'group_name' => 'contact', 'label' => 'Address'],
            ['key' => 'office_hours', 'value' => 'Mon-Fri: 9:00 AM - 6:00 PM\nSat: 9:00 AM - 2:00 PM\nSun: Closed', 'type' => 'textarea', 'group_name' => 'contact', 'label' => 'Office Hours'],

            // Social Media
            ['key' => 'social_facebook', 'value' => '', 'type' => 'text', 'group_name' => 'social', 'label' => 'Facebook URL'],
            ['key' => 'social_twitter', 'value' => '', 'type' => 'text', 'group_name' => 'social', 'label' => 'Twitter URL'],
            ['key' => 'social_linkedin', 'value' => '', 'type' => 'text', 'group_name' => 'social', 'label' => 'LinkedIn URL'],
            ['key' => 'social_instagram', 'value' => '', 'type' => 'text', 'group_name' => 'social', 'label' => 'Instagram URL'],
            // Appearance Settings
            ['key' => 'hero_image', 'value' => '', 'type' => 'image', 'group_name' => 'appearance', 'label' => 'Hero Image'],
        ];

        foreach ($defaultSettings as $setting) {
            SiteSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Default settings initialized successfully!',
        ]);
    }
}
