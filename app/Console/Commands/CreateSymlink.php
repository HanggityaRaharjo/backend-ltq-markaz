<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateSymlink extends Command
{
    protected $signature = 'custom:symlink';

    protected $description = 'Create symbolic link for public storage';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $target = public_path('storage');
        $link = public_path('storage');

        if (!file_exists($link)) {
            symlink($target, $link);
            $this->info('Symlink created successfully.');
        } else {
            $this->warn('Symlink already exists.');
        }
    }
}
