<?php

namespace Joy2fun\FilamentExt\Traits\Auth;

use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Section;
use Joy2fun\FilamentExt\Models\SmsCode;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Validation\Rules\Password;
use Joy2fun\FilamentExt\Forms\Components\SmsCodeInput;

trait SignupForm
{
    public ?array $data = [];

    public function defaultForm(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Section::make([
                    TextInput::make('name')->label('姓名')
                        ->required(),
                    TextInput::make('password')->password()->label('密码')
                        ->rules([
                            Password::min(8)->letters()->numbers(),
                        ])
                        ->required(),
                    TextInput::make('password2')->password()->label('确认密码')->same('password')
                        ->dehydrated(false)
                        ->validationMessages([
                            'same' => '两次密码不一致'
                        ])
                        ->required(),
                    TextInput::make('mobile')->label('手机号')
                        ->required(),
                    SmsCodeInput::make('code')->hiddenLabel()
                        ->rules([
                            'required',
                            fn(Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                SmsCode::attempt($get('mobile') ?? '', $value) or $fail('验证码无效');
                            },
                        ]),
                ])->heading('注册新账号')
                    ->footerActions([
                        Action::make('注册新账号')->size('xl')->submit('signup'),
                        Action::make('已有账号登录')->link()->url('signin'),
                    ])
                    ->footerActionsAlignment(Alignment::Center)
                    ->extraAttributes(['class' => 'min-w-96'])
            ]);
    }
}
