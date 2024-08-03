<?php

namespace Joy2fun\FilamentExt\Forms\Concerns;

use Closure;

interface SmsCodeSender
{
    public function getSmsCodeSender(): Closure;
}
