<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearTmpFolderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ehjiz:clear-tmp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear tmp folder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = 0;
        
        collect(Storage::disk('public')->listContents('tmp', true))
        ->each(function($file) use (&$count) {
            if ($file['type'] == 'file' && $file['timestamp'] < now()->subDays(1)->getTimestamp()) {
                return Storage::disk('public')->delete($file['path']) ? $count++ : null;
            }
        });

        $this->info("$count files successfully deleted");
    }
}