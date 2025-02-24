<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BooksController;


Route::get('/', function () {
    return view('index');
});

// Login Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('authors.dashboard');

// Author Routes
Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');

Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show'); // View single author
Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy'); // Delete author



// Book Routes 1
// Route::get('books/create', [BookController::class, 'create'])->name('books.create'); // Show create book form
// Route::post('books', [BookController::class, 'store'])->name('books.store'); 


// Books Routes2
// Route::get('books/create', [BookController::class, 'create'])->name('books.create');// Show create book form
// Route::get('books/{author}', [BookController::class, 'show'])->name('books.show');// Show create book form
// Route::post('books', [BookController::class, 'store'])->name('books.store');// Store new book
// Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.delete');


// Books Routes3
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
Route::get('/authors/{authorId}/books', [BookController::class, 'show'])->name('books.show');
Route::delete('/books/{bookId}', [BookController::class, 'destroy'])->name('books.destroy');


// // Author Routes
// Route::middleware('auth')->get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
// Route::middleware('auth')->delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');

// // Book Routes
// Route::middleware('auth')->get('/books', [BookController::class, 'index'])->name('books.index');
// Route::middleware('auth')->get('/books/create', [BookController::class, 'create'])->name('books.create');
// Route::middleware('auth')->post('/books', [BookController::class, 'store'])->name('books.store');
// Route::middleware('auth')->get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Logout Route
Route::post('/logout', function () {
    session()->flush();
    return redirect('/login');
});

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

