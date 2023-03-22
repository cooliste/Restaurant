<?php

use Modules\Port\Http\Controllers;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Route;

$module = Module::find('Port');
if ($module && $module->isEnabled()) {
    $route = module_data('Port', 'route');
    Route::prefix($route)->middleware(['auth', 'role:super'])->group(function () {
        Route::view('/', 'port::index')->name('port');

        Route::get('/brands', [Controllers\BrandController::class, 'index'])->name('brands.port');
        Route::post('/brands', [Controllers\BrandController::class, 'save'])->name('brands.import');
        Route::post('/brands/export', [Controllers\BrandController::class, 'export'])->name('brands.export');

        Route::get('/categories', [Controllers\CategoryController::class, 'index'])->name('categories.port');
        Route::post('/categories', [Controllers\CategoryController::class, 'save'])->name('categories.import');
        Route::post('/categories/export', [Controllers\CategoryController::class, 'export'])->name('categories.export');
    });
}
