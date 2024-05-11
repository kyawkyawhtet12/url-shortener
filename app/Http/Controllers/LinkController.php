<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Link;
use Illuminate\Support\Facades\Redirect;


class LinkController extends Controller
{
    public function shortUrl(Request $request)
    {
        return Link::shortenUrl($request->url);
    }

    public function redirectUrl(Request $request)
    {
        $link = Link::where('code', $request->code)->first();

        if(isset($link)){
            return view('redirect', ['redirect_url'=>$link->original_url ?? "www.google.com"]);
            // return redirect()->away($link->original_url);
        }else{
            return response()->json(['message'=> 'Link not found']);
        }
    }
}
