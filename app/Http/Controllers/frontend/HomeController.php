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

        // Check if mobile request
        if (request()->header('User-Agent') && $this->isMobileRequest()) {
            return view('mobile.frontend.home', compact('settings', 'content', 'doctors'));
        }

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

        // Check if mobile request
        if (request()->header('User-Agent') && $this->isMobileRequest()) {
            return view('mobile.frontend.about', compact('settings', 'content'));
        }

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

        // Check if mobile request
        if (request()->header('User-Agent') && $this->isMobileRequest()) {
            return view('mobile.frontend.contact', compact('settings', 'content'));
        }

        return view('frontend.contact', compact('settings', 'content'));
    }

    private function isMobileRequest()
    {
        $userAgent = request()->header('User-Agent', '');
        $mobilePatterns = ['Mobile', 'Android', 'iPhone', 'iPad', 'iPod', 'BlackBerry', 'Windows Phone'];
        
        foreach ($mobilePatterns as $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                return true;
            }
        }
        
        return request()->has('mobile') && request()->get('mobile') === '1';
    }
}
