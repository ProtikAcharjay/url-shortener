<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use Carbon\Carbon;
use App\Models\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UrlController extends Controller
{
    public function processUrl(Request $request){
        $request->validate(
            ['url' =>'required|url']
        );
        $random_number = rand(1,9999999);
        $short_url = env('APP_URL'). 'url/' . $random_number;
        $expire_at = Carbon::now()->addMinutes(30);
        
        $url_model = new URL();
        $url_model->url = $request->url;
        $url_model->short_code = $random_number;
        $url_model->expire_at = $expire_at;
        $url_model->save();
        Log::info("URL saved successfully", [
            'url' => $request->url,
            'short_code' => $random_number,
            'expire_at' => $expire_at,
        ]);

        return response()->json(['short_url' => $short_url, 'expire_at' => $expire_at], 200);
        
    }
    public function redirectUrl($id){
        $url = URL::where('short_code', $id)->first();

        abort_if(!$url, 404, 'URL not found');

        abort_if(Carbon::now()->greaterThan($url->expire_at), 410, 'This URL has expired');
        
        return redirect($url->url);
    }
    public function test(){
        TestJob::dispatch()->onQueue('test');
        dd("dispatched test job in test queue");
        // $url = 'https://mail.google.com/mail/u/0/#inbox/QgrcJHsNqLLbHslRFHFtHVCqDrcSJzSrJLB';
        // $url_model = new URL();
        // $url_model->url = $url;
        // $url_model->short_code = rand(1,9999999);
        // $url_model->save();
    }
}
