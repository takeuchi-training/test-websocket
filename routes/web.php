<?php

use App\Events\GetRequestEvent;
use App\Events\SendMessageEvent;
use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\ApplicationController;
use App\Jobs\SendWelcomeEmailJob;
use App\Mail\WelcomeEmail;
use App\Models\Application;
use App\Models\User;
use App\Repositories\ChatRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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

Route::get('/test-websocket/{room_id}', function ($room_id, ChatRepositoryInterface $chatRepository) {
    if (!Gate::allows('enter_room', $room_id)) {
        abort(403);
    }

    $room = $chatRepository->getChatRoom($room_id);
    $messages = $chatRepository->getGroupChatMessages($room_id);

    return view('test.testWebsocket', [
        'room' => $room,
        'messages' => $messages
    ]);
})->middleware(['auth'])->name('testWebsocket');

Route::post('/test-websocket/{room_id}', function (Request $request, ChatRepositoryInterface $chatRepository, $room_id) {
    if (!Gate::allows('enter_room', $room_id)) {
        abort(403);
    }

    $input = $request->validate([
        'user_id' => 'required',
        'message' => 'required'
    ]);
    
    $user = User::find($input['user_id']);

    $room = $chatRepository->getChatRoom($room_id);

    event(new SendMessageEvent($room, $user, $input['message']));

    return [
        'response' => $input,
        'user' => $user
    ];
})->middleware(['auth']);

Route::get('/chat-rooms', function (ChatRepositoryInterface $chatRepository) {
    $user = auth()->user();
    $rooms = $chatRepository->getUserGroupChats($user->id);
    $roomIds = $rooms->map(fn($room) => $room->id);
    $roomUsers = $chatRepository->getUserGroupChatsWithUsers($roomIds);

    return view('test.chatRooms', [
        'rooms' => $rooms,
        'roomUsers' => $roomUsers,
    ]);
})->middleware(['auth'])->name('chatRooms');

Route::name('applications.')
    ->prefix('/applications')
    ->controller(ApplicationController::class)
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::prefix('/{application_id}')->group(function () {
            Route::put('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });
    });

Route::name('admin.applications.')
    ->prefix('/admin/applications')
    ->controller(AdminApplicationController::class)
    ->middleware(['auth', 'is_admin'])
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::prefix('/{application_id}')->group(function () {
            Route::get('/', 'show')->name('show');
            Route::post('/approve', 'approve')->name('approve');
            Route::post('/deny', 'deny')->name('deny');
        });
    });

