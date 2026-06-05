<?php

use App\Http\Controllers\AboutusController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Route;

Route::apiResource("sliders", SliderController::class);
Route::apiResource("features", AboutusController::class);
Route::apiResource("aboutus", AboutusController::class)->parameters([
    'aboutus' => 'aboutus'
]);;
