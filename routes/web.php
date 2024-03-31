<?php

use Framework\Http\Response;
use Framework\Routing\Route;
use App\Controllers\HomeController;
use App\Controllers\PostController;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/posts/{id:\d+}', [PostController::class, 'show']),
    Route::get('/hello/{name}', function(string $name) {
        return new Response("Hello, {$name}!", 200);
    }),
    Route::get('/posts/create', [PostController::class, 'create']),
];