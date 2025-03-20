<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerController;

Route::post('/managers', [ManagerController::class, 'store'])->name('managers.store');
