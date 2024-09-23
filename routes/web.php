<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/skills', function () {
    return view('skills');
})->name('skills.index');

Route::get('/cv.pdf', function () {
    return \Spatie\LaravelPdf\Support\pdf()
        ->view('welcome')
        ->format(\Spatie\LaravelPdf\Enums\Format::A4)
        ->withBrowsershot(fn (\Spatie\Browsershot\Browsershot $browsershot) => $browsershot
            ->noSandbox()
            ->setOption('addStyleTag', json_encode(['content' => ':root { font-size: 10px; }']))
            ->timeout(60));
})->name('home');
