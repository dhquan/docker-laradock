<?php

use Illuminate\Http\Request;

Use App\Article;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//api products
Route::apiResource('products', 'ProductsController');
