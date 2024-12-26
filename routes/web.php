<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('FlowerGallery'); // Make sure 'Welcome' matches the name of your .vue file in Pages
});
