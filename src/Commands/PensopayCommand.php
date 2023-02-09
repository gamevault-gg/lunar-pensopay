<?php

namespace Gamevault\Pensopay\Commands;

use Illuminate\Console\Command;

class PensopayCommand extends Command
{
    public $signature = 'lunar-pensopay';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
