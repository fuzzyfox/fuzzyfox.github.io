<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExportCleanUrlsCommand extends Command
{
    protected $signature = 'export:clean-urls';

    protected $description = 'Command description';

    public function handle(): void
    {
        $disk = Storage::disk(config('export.disk'));

        foreach (config('export.paths') as $path) {
            $path = $path.'/index.html';

            if (! $disk->exists($path)) {
                continue;
            }

            $disk->put(
                $path,
                Str::replace(
                    config('app.url'),
                    '',
                    $disk->get($path)
                )
            );
        }
    }
}
