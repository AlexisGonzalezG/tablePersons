<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

Route::post('/insertPerson', [PersonController::class, 'insertPerson']);
Route::put('/updatePerson/{id}', [PersonController::class, 'updatePerson']);
Route::delete('/deletePerson/{id}', [PersonController::class, 'deletePerson']);
Route::get('/persons', [PersonController::class, 'getAllPersons']);