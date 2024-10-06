<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function processUrl(Request $request){
        $request->validate(
            ['url' =>'required|url']
        );
        
        dd($request->url);
    }
}
