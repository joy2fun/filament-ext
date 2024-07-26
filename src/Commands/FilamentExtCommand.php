<?php

namespace Joy2fun\FilamentExt\Commands;

use Illuminate\Console\Command;

class FilamentExtCommand extends Command
{
    public $signature = 'filament-ext';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
