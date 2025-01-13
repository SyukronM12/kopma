<?php

use Illuminate\Support\Facades\Route;
use Filament\Http\Livewire\Auth\Login;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/login', Login::class)->name('login');