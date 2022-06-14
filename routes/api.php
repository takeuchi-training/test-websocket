<?php

use App\Events\SendMessageEvent;
use App\Models\User;
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
        'user_id' => 'required',
        'message' => 'required'
    ]);

    $user = User::find($input['user_id']);

    event(new SendMessageEvent($user, $input['message']));

    return [
        'response' => $input,
        'user' => $user
    ];
});