<?php

namespace App\Http\Controllers;

class LocalizationController extends Controller
{
    public function switch($language = 'id')
    {
        request()->session()->put('locale', $language);
        return redirect()->back();
    }
}
