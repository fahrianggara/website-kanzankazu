<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
        $typesSelected = in_array($request->type, ['image', 'file']) ? $request->type : "image";
        return view('filemanager.index', [
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
