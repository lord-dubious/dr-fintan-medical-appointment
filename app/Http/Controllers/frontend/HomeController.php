<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\PageContent;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    //
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $content = PageContent::getPageContent('home')
            ->map(function ($group) {
                return $group->pluck('content_value', 'content_key');
            })
            ->toArray();
        $doctors = Doctor::all();

        return view('frontend.home', compact('settings', 'content', 'doctors'));
    }

    public function about()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $content = PageContent::getPageContent('about')
            ->map(function ($group) {
                return $group->pluck('content_value', 'content_key');
            })
            ->toArray();

        return view('frontend.about', compact('settings', 'content'));
    }

    public function contact()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $content = PageContent::getPageContent('contact')
            ->map(function ($group) {
                return $group->pluck('content_value', 'content_key');
            })
            ->toArray();

        return view('frontend.contact', compact('settings', 'content'));
    }
}
