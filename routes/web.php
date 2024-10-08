<?php

use App\Models\Position;
use App\Models\Skill;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::get('/skills', fn () => view('skills'))->name('skills.index');

Route::get('/positions/{position}', fn (Position $position) => view('positions.show', [
    'position' => $position->loadMissing(['skills']),
]))->name('positions.show');

Route::get('cv', fn () => view('cv'));

if (App::isLocal()) {
    Route::get('/cv.pdf', function () {
        return \Spatie\LaravelPdf\Support\pdf()
            ->view('cv')
            ->format(\Spatie\LaravelPdf\Enums\Format::A4)
            ->withBrowsershot(fn (\Spatie\Browsershot\Browsershot $browsershot) => $browsershot
                ->noSandbox()
                ->setOption('addStyleTag', json_encode(['content' => ':root { font-size: 10px; }']))
                ->timeout(60));
    });
}
