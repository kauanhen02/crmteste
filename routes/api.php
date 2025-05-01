<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RelatorioController;

Route::get('/relatorio/dados', [RelatorioController::class, 'dados']);
