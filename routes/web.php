<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupportController;

Route::get('/', [SupportController::class, 'show'])->name('support.form');
Route::post('/enviar', [SupportController::class, 'send'])->name('support.send');
