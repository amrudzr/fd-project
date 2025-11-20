<?php

namespace App\Rules;

use Closure;
use ReCaptcha\ReCaptcha;
use Illuminate\Contracts\Validation\ValidationRule;

class Captcha implements ValidationRule
{
    public function passes($attribute, $value)
    {
        $recaptcha = new ReCaptcha(env('CAPTCHA_SECRET'));
        $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);
        return $response->isSuccess();
    }
}
