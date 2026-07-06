<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {

        $request->validate([
            'file'=>'required|file|max:51200'
        ]);

        $path=$request->file('file')
        ->store('uploads','public');

        return response()->json([
            'success'=>true,
            'file_name'=>$request->file('file')->getClientOriginalName(),
            'path'=>$path,
            'url'=>asset('storage/'.$path)
        ]);
    }
}
