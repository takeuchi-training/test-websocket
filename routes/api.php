<?php

use App\Events\SendMessageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/test-websocket', function (Request $request) {
    $input = $request->validate([
        'name' => 'required',
        'message' => 'required'
    ]);

    event(new SendMessageEvent($input['name'], $input['message']));

    return $input;
});