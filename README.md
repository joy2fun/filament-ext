## sms code

config sender method:
```php
Joy2fun\FilamentExt\Models\SmsCode::using(function(SmsCode $model) {
    // 发送短信
    // sendSms($model->mobile, $model->code);
});
```

use trait in livewire component:
```php
use Joy2fun\FilamentExt\Forms\Concerns\InteractsWithSmsCode;
```

use input in filament form
```php
Joy2fun\FilamentExt\Forms\Components\SmsCodeInput::make('code')
    ->viewData([
        'mobile' => $mobile // 默认填入手机号
    ])
    // ->suffixButton()
    ;
```

verify the mobile and code pair
```php
if (!Joy2fun\FilamentExt\Models\SmsCode::attempt($mobile, $code)) {
    // 验证码错误
}
```
