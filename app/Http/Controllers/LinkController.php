<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Link;
use Illuminate\Support\Facades\Redirect;


class LinkController extends Controller
{
    public function shortUrl(Request $request)
    {
        $shorten_url = Link::shortenUrl($request->url);

        return $shorten_url->code;
    }

    public function redirectUrl(Request $request)
    {
        $link = Link::where('code', $request->code)->first();

        if(isset($link)){
            return redirect()->away($link->original_url);
        }else{
            return response()->json(['message'=> 'Link not found']);
        }
    }
}
