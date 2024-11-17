<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

Route::get('/anime/{anime:slug}', [AnimeController::class, 'show'])->where('anime', '[a-z0-9-]+');
