<?php

use App\Livewire\AboutUs;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/about', AboutUs::class)->name('about');
