<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tutorial;
use App\Models\WebSetting;
use Illuminate\Support\Facades\View;

use Artesaos\SEOTools\Facades\SEOTools;

class HomeController extends Controller
{

    public function index()
    {
        $setting = WebSetting::find(1);

        SEOTools::setTitle($setting->site_name);
        SEOTools::setDescription($setting->site_description);
        SEOTools::opengraph()->setUrl(route('homepage'));
        SEOTools::setCanonical(route('homepage'));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('@' . $setting->site_name);
        SEOTools::jsonLd()->addImage(asset('vendor/blog/img/home-img/' . $setting->image_banner));

        return view('layouts.home', [
            'posts' => Post::publish()->latest()->limit(3)->get(),
            'categories' =>  Category::onlyParent()
                ->whereHas('posts', function ($query) {
                    $query->publish();
                })->latest()->limit(3)->get(),
            'tutorials' => Tutorial::whereHas('posts', function ($query) {
                $query->publish();
            })->latest()->limit(3)->get(),
        ]);
    }
}
