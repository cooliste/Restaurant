<?php

use Illuminate\Support\Facades\Route;
use Tecdiary\Installer\Http\Middleware\CanInstall;

Route::view('/offline', 'offline');
Route::view('/welcome', 'welcome');
Route::redirect('/', '/install')->middleware(CanInstall::class);
