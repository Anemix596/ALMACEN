<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/daf', function (Request $request) {
    return $request->user();
});