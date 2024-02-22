<?php

namespace Envor\OneApp\Commands;

use Illuminate\Console\Command;

class OneAppCommand extends Command
{
    public $signature = 'one-app';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
