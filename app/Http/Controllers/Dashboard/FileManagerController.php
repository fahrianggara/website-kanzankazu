<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Support\Facades\View;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
        $setting = WebSetting::find(1);
        View::share('setting', $setting);

        $typesSelected = in_array($request->type, ['image', 'file']) ? $request->type : "image";
        return view('dashboard.filemanager.index', [
            'types' => $this->types(),
            'typesSelected' => $typesSelected,
        ]);
    }

    private function types()
    {
        return [
            'image' => "Image",
            'file'  => "File"
        ];
    }
}
