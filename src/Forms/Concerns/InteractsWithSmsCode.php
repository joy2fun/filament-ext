<?php

namespace Joy2fun\FilamentExt\Forms\Concerns;

use Exception;
use Filament\Notifications\Notification;
use Joy2fun\FilamentExt\Models\SmsCode;

trait InteractsWithSmsCode
{
    public function sendSmsCode(string $mobile)
    {
        if (strlen($mobile) < 11) {
            $this->dispatch('sms-code-reset-count', count: 0);
            Notification::make()
                ->title('无效的手机号')
                ->warning()
                ->send();
            return;
        }

        if ($seconds = SmsCode::canSendAfter($mobile)) {
            $this->dispatch('sms-code-reset-count', count: $seconds);
            Notification::make()
                ->title('操作太频繁，请稍后再试')
                ->warning()
                ->send();
            return;
        }

        try {
            SmsCode::generate($mobile);
            Notification::make()
                ->title('验证码已发送')
                ->success()
                ->send();
        } catch (Exception $e) {
            report($e);
            $this->dispatch('sms-code-reset-count', count: 0);
            Notification::make()
                ->title('发送失败')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
