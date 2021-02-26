<?php

use App\Http\Controllers\QuoteController;
use App\Http\Controllers\UserController;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

# Example
Route::get(
    '/quotes/barney',
    [QuoteController::class, 'index']
);

# The API returns a list of quotes for a citizen
Route::get(
    '/quotes/{username}',
    function (string $username) {
        return (new QuoteController())->listQuotes($username);
    }
);

# A quote can be added for a citizen
Route::post(
    '/add-quote/{username}/{quote}',
    function (string $username, string $quote) {
        return (new QuoteController())->addQuote($username, $quote);
    }
);

# The names and addresses of citizens can be edited
Route::put(
    '/citizen/update/{username}',
    function (Request $request, string $username) {
        return (new UserController())->update($request, $username);
    }
);

# The API returns a list of Sheffield's citizens
Route::get(
    '/citizens',
    [UserController::class, 'listCitizens']
);

