<?php

namespace App\Export\Jobs;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Spatie\Export\Destination;

class ExportPath extends \Spatie\Export\Jobs\ExportPath
{
    public function handle(Kernel $kernel, Destination $destination, UrlGenerator $urlGenerator)
    {
        $localRequest = Request::create($urlGenerator->to($this->path));

        $localRequest->headers->set('X-Laravel-Export', 'true');

        $response = $kernel->handle($localRequest);

        if ($response->status() !== 200) {
            Log::driver('stderr')->error($response->content());

            throw new RuntimeException("Path [{$this->path}] returned status code [{$response->status()}]");
        }

        $destination->write($this->normalizePath($this->path), $response->content());
    }
}
