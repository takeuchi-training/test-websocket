<?php

use App\Events\GetRequestEvent;
use App\Events\SendMessageEvent;
use App\Jobs\SendWelcomeEmailJob;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/test-dispatch', function () {
    $user = User::factory()->create();
    SendWelcomeEmailJob::dispatchAfterResponse($user->email);
    $user->delete();

    return response('Test done!');
});

require __DIR__.'/auth.php';

Route::get('/trigger/{data}', function ($data) {
    echo "<p>You have sent $data.</p>";
    event(new GetRequestEvent($data));
});

Route::get('/test-websocket', function () {
    return view('test.testWebsocket');
});

Route::post('/test-websocket', function (Request $request) {
    $input = $request->validate([
        'name' => 'required',
        'message' => 'required'
    ]);

    event(new SendMessageEvent($input['name'], $input['message']));

    return back();
});