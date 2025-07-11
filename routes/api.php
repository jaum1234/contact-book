<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::post('/contacts', [ContactController::class, 'store'])
    ->name('contacts.store');
