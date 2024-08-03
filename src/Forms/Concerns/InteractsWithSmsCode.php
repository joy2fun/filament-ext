<?php

namespace Joy2fun\FilamentExt\Forms\Concerns;

use Closure;
use Exception;
use Joy2fun\FilamentExt\Models\SmsCode;
use Throwable;

trait InteractsWithSmsCode
{
    public function getSmsCodeSender(): Closure
    {
        return function(string $mobile, string $code) {
            throw new Exception('missing getSmsCodeSender(): fn(string $mobile, string $code) => send_sms($mobile, $code)');
        };
    }

    public function sendSmsCode(string $mobile)
    {
        // popup captcha if necessary
        if (method_exists($this, 'captchaShouldPass') && ! $this->captchaShouldPass()) {
            $this->popupCaptcha();
            $this->dispatch('sms-code-reset-count', count: 0);

            return;
        }

        if ($seconds = SmsCode::canSendAfter($mobile)) {
            $this->dispatch('sms-code-reset-count', count: $seconds);

            return;
        }

        // notification may trigger twice for full page components
        // dispatch events to trigger notification
        try {
            SmsCode::generate($mobile, $this->getSmsCodeSender());
            $this->dispatch('sms-code-sent');
        } catch (Throwable $e) {
            report($e);
            $this->dispatch('sms-code-sent-failed', message: $e->getMessage());
        }
    }
}
