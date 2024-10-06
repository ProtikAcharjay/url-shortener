<?php

namespace App\Http\Controllers;

use App\Models\URL;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function processUrl(Request $request){
        $request->validate(
            ['url' =>'required|url']
        );
        $random_number = rand(1,9999999);
        $short_url = env('APP_URL') . $random_number;

        $url_model = new URL();
        $url_model->url = $request->url;
        $url_model->short_code = $random_number;
        $url_model->save();

        return response()->json(['short_url' => $short_url], 200);
        
    }
    public function redirectUrl($id){
        $url = URL::where('short_code', $id)->pluck('url')->first();
        return redirect($url);
    }
    public function test(){
        $url = 'https://mail.google.com/mail/u/0/#inbox/QgrcJHsNqLLbHslRFHFtHVCqDrcSJzSrJLB';
        $url_model = new URL();
        $url_model->url = $url;
        $url_model->short_code = rand(1,9999999);
        $url_model->save();
    }
}
