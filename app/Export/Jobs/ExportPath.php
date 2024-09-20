<?php

namespace App\Export\Jobs;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use RuntimeException;
use Spatie\Export\Destination;

class ExportPath extends \Spatie\Export\Jobs\ExportPath
{
    public function handle(Kernel $kernel, Destination $destination, UrlGenerator $urlGenerator)
    {
        $localRequest = Request::create($urlGenerator->to($this->path));

        $localRequest->headers->set('X-Laravel-Export', 'true');

        $route = app('router')->getRoutes()->match($localRequest);

        /** @var Response $response */
        $response = app()->handle(Request::createFromBase($localRequest));

        if ($response->status() !== 200) {
            throw new RuntimeException("Path [{$this->path}] returned status code [{$response->status()}]", previous: $response->toException());
        }

        $destination->write($this->normalizePath($this->path), $response->content());
    }
}
