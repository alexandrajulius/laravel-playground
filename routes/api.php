<?php

use App\Http\Controllers\QuoteController;
use App\Http\Controllers\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

# Example
Route::get(
    '/quotes',
    [QuoteController::class, 'index']
);

# The API returns a list of quotes for an author
Route::get(
    '/quotes/{username}',
    function (string $username) {
        return (new QuoteController())->listQuotes($username);
    }
);

# A quote can be added for an author
Route::post(
    '/add-quote/{username}/{quote}/{book}',
    function (string $username, string $quote, string $book) {
        return (new QuoteController())->addQuote($username, $quote, $book);
    }
);

# The names and books of authors can be edited
Route::put(
    '/author/update/{username}',
    function (Request $request, string $username) {
        return (new AuthorController())->update($request, $username);
    }
);

# The API returns a list of authors
Route::get(
    '/authors',
    [AuthorController::class, 'listAuthors']
);

