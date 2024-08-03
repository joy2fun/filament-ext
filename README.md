## sms code

use trait in livewire component:
```php
use Joy2fun\FilamentExt\Forms\Concerns\InteractsWithSmsCode;

// setup a sender
public function getSmsCodeSender(): Closure
{
    return function(string $mobile, string $code) {
        // send sms 
        Log::debug("sms sent", func_get_args());
    };
}
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
