<?php

use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Route;

Route::apiResource("sliders" , SliderController::class);