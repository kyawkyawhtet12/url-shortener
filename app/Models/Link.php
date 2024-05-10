<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
use KyawKyawHtet\UrlFormatter\UrlFormatter;


class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_url',
        'shorten_url',
        'code',
    ];

    public static function shortenUrl($origianl_url)
    {
        $validated_url = self::setLinkAttribute($origianl_url);
        $link = self::create(['original_url'=>$validated_url]);
        $code = Str::random(6);
        $link->code = $code;
        $link->shorten_url = env('APP_URL'). '/' . $code;
        $link->save();

        return $link->code;
    }

    public static function setLinkAttribute($value)
    {
        return $formattedUrl = self::format($value);
    }

    private static function format($value)
    {
        // Check if the link doesn't already start with 'http://' or 'https://'
        if (!preg_match("~^(?:f|ht)tps?://~i", $value)) {
            // If not, prepend 'https://' to the link
            return 'https://' . $value;
        } else {
            // Otherwise, use the link as it is
            return $value;
        }
    }
}
