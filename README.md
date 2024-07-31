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
[
    TextInput::make('phone')
        ->regex('/^\d{10,15}$/')
        ->rules(['required'])
        ->label('手机号'),
    SmsCodeInput::make('code')
        ->mobileField('phone')
        ->dehydrated(false)
        ->regex('/^\d{4,6}$/')
        ->label('验证码')
        ->rules([
            'required',
            fn(Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                SmsCode::attempt($get('phone') ?? '', $value) or $fail('验证码无效');
            },
        ]),
]
```

verify the mobile and code pair
```php
if (!Joy2fun\FilamentExt\Models\SmsCode::attempt($mobile, $code)) {
    // 验证码错误
}
```


## popup captcha

```php
use Joy2fun\FilamentExt\Forms\Concerns\InteractsWithCaptcha;
```

include blade view
```blade
@include('filament-ext::components.captcha')
```

captcha free minutes if passed validation
```php
config([
    'filament-ext.captcha_free_minutes' => 10,
])
```
