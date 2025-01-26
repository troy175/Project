<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActionController;

// Route for the home page
Route::get('/', function () {
    return view('welcome'); // Change this to your main view if needed
});

// Route to display the form and saved actions
Route::get('/form', function () {
    return view('form'); // Ensure you have a view named 'form.blade.php'
});

// Route to handle form submission
Route::post('/post', [ActionController::class, 'store'])->name('action.store');

// Resource routes for actions
Route::resource('actions', ActionController::class);