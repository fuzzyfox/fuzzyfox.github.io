<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/skills', function () {
    return view('skills');
})->name('skills.index');
