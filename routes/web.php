<?php

use App\Models\Position;
use App\Models\Project;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use function Spatie\LaravelPdf\Support\pdf;

Route::get('/', fn () => view('welcome'))->name('home');

Route::get('/skills', fn () => view('skills'))->name('skills.index');

Route::get('/positions/{position:slug}', fn (Position $position) => view('positions.show', [
    'position' => $position->loadMissing(['skills']),
]))->name('positions.show');

Route::get('/projects/{project:slug}', fn (Project $project) => view('projects.show', [
    'project' => $project->loadMissing(['skills']),
]))->name('projects.show');

Route::view('/projects', 'projects.index')->name('projects.index');

Route::get('cv', fn () => view('cv'))->name('cv');
Route::redirect('resume', 'cv', 307);

if (App::isLocal()) {
    Route::get('/cv.pdf', function () {
        $appUrl = config('app.url');

        return pdf()
            ->view('cv')
            ->format(Format::A4)
            ->withBrowsershot(fn (Browsershot $browsershot) => $browsershot
                ->noSandbox()
                ->setOption('addStyleTag', json_encode(['content' => ':root { font-size: 10px; }']))
                ->setOption('addScriptTag', json_encode(['content' => "[...document.querySelectorAll('a')].forEach(a => {a.href = a.href.replace('http://localhost', '$appUrl')})"]))
                ->delay(200)
                ->timeout(60));
    });
}
