<?php

namespace Joy2fun\FilamentExt\Forms\Concerns;

trait InteractsWithCaptcha
{
    public $captchaTips = '输入验证码';

    public $captchaCode;

    public function captchaFreeMinutes(): int
    {
        return config('filament-ext.captcha_free_minutes', 10);
    }

    public function captchaShouldPass()
    {
        return now()->subMinutes($this->captchaFreeMinutes())->unix() <= session('captcha_passed_at', 0);
    }

    public function popupCaptcha()
    {
        $this->dispatch('open-modal', id: 'captcha');
    }

    public function reloadCaptcha()
    {
        $this->captchaCode = '';
        $this->captchaTips = '输入验证码';
    }

    public function checkCaptcha()
    {
        $rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(['captcha' => $this->captchaCode], $rules);
        $this->captchaCode = '';

        if ($validator->fails()) {
            $this->captchaTips = '验证失败，请重新输入';
        } else {
            $this->dispatch('close-modal', id: 'captcha');
            $this->captchaTips = '输入验证码';
            session(['captcha_passed_at' => now()->unix()]);
        }
    }
}
