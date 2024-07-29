<?php

namespace Joy2fun\FilamentExt\Forms\Components;

use Filament\Forms\Components\Field;

class SmsCodeInput extends Field
{
    protected string $view = 'filament-ext::forms.components.sms-code';

    public function suffixButton($bool = true)
    {
        $this->viewData(['suffix_button' => $bool]);

        return $this;
    }
}
