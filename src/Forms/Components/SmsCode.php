<?php

namespace Joy2fun\FilamentExt\Forms\Components;

use Filament\Forms\Components\Field;

class SmsCode extends Field
{
    protected string $view = 'filament-ext::forms.components.sms-code';

    public function suffixButton($bool = true)
    {
        $this->viewData(['suffixButton' => $bool]);

        return $this;
    }
}
