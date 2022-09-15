<?php

namespace App\Http\Controllers\Utils;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CaptchaController extends UnCommonController
{
    public function captcha(Request $request, $captcha = 'captcha'): StreamedResponse
    {
        $width   = $request->get('width', 152);
        $height  = $request->get('height', 42);
        $length  = $request->get('length', 4);
        $builder = new CaptchaBuilder(builder: new PhraseBuilder($length, '23456789ABCDEF'));
        if (config('app.env') != 'production') {
            $builder->setPhrase(6868);
        }
        $builder->setBackgroundColor(255, 255, 255);
        $builder->setIgnoreAllEffects(false);
        $builder->setMaxBehindLines(5);
        $builder->setMaxFrontLines(5);
        $builder->build($width, $height);
        $request->session()->put($captcha, strtolower($builder->getPhrase()));
        $headers = [
            'Cache-Control' => 'no-cache, must-revalidate',
            'Content-Type' => 'image/webp',
        ];
        return response()->stream(function () use ($builder) {
            return $builder->output();
        }, 200, $headers);
    }
}
