<?php

namespace Joy2fun\FilamentExt\Forms\Concerns;

trait InteractsWithCaptcha
{
    protected function captchaFreeMinutes(): int
    {
        return config('filament-ext.captcha_free_minutes', 10);
    }

    protected function captchaShouldPass()
    {
        return config('captcha.disable', false) || now()->subMinutes($this->captchaFreeMinutes())->unix() <= session('captcha_passed_at', 0);
    }

    protected function popupCaptcha()
    {
        $this->dispatch('captcha-load', url: captcha_src());
        $this->dispatch('open-modal', id: 'captcha');
    }

    public function realodCaptcha()
    {
        $this->dispatch('captcha-load', url: captcha_src());
    }

    public function checkCaptcha($code)
    {
        $rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(['captcha' => $code], $rules);

        if ($validator->fails()) {
            $this->dispatch('captcha-failed', url: captcha_src());
        } else {
            $this->dispatch('close-modal', id: 'captcha');
            $this->dispatch('captcha-passed');
            session(['captcha_passed_at' => now()->unix()]);
        }
    }
}
