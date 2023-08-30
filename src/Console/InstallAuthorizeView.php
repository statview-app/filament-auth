<?php

namespace Statview\FilamentAuth\Console;

use Illuminate\Console\Command;

class InstallAuthorizeView extends Command
{
    protected $signature = 'filament-auth:install-authorize-view';

    protected $description = 'This command installs the passport authorize view';

    public function handle(): void
    {
        $targetDir = base_path('resources/views/vendor/passport');

        if (! is_dir($targetDir)) {
            mkdir($targetDir);
        }

        $targetDir.='/authorize.blade.php';

        copy(__DIR__.'/../../resources/views/authorize.blade.php', $targetDir);

        $this->info('Published the authorize blade file');
    }
}