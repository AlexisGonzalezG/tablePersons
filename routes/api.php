<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\tables_controller;

Route::post('/insertPerson', [PersonController::class, 'insertPerson']);
Route::put('/updatePerson/{id}', [PersonController::class, 'updatePerson']);
Route::delete('/deletePerson/{id}', [PersonController::class, 'deletePerson']);
Route::get('/persons', [PersonController::class, 'getAllPersons']);

Route::get('/statusList', [tables_controller::class, 'status_list']);