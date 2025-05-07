<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});

// ROUTE ---> PRESENTAZIONE DELLE NOTE
Route::get('/notes/index', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notes/show/{id}', [NoteController::class, 'show'])->name('notes.index');

// ROUTE ---> RAGGRUPPAMENTO ROUTE SOLO PER UTENTI AUTENTICATI
Route::middleware(['auth'])->group(function () {
    // ROUTE ---> CREAZIONE E STORAGGIO DELLE NOTE
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes/store', [NoteController::class, 'store'])->name('notes.store');

    // ROUTE ---> MODIFICA E AGGIORNAMENTO DELLE NOTE
    Route::get('/notes/edit/{id}', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{id}', [NoteController::class, 'update'])->name('notes.update');

    // ROUTE ---> CANCELLAZIONE DELLE NOTE
    Route::delete('/notes/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('notes', NoteController::class);