<?php 

namespace App\Repositories;

use App\Models\Message;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class ChatRepositoryImpl implements ChatRepositoryInterface {
    public function getChatRoom($room_id) {
        return Room::findOrFail($room_id);
    }

    public function getGroupChatMessages($room_id) {
        return DB::table('messages')
            ->join('users', 'messages.user_id', '=', 'users.id')
            ->join('rooms', 'messages.room_id', '=', 'rooms.id')
            ->selectRaw('rooms.id as room_id, users.name as user_name, messages.content, messages.created_at')
            ->orderBy('messages.created_at', 'desc')
            ->where('rooms.id', $room_id)
            ->get();
    }

    public function getGroupChatUsers($room_id) {
        return DB::table('room_user')
        ->join('users', 'room_user.user_id', '=', 'users.id')
        ->select('room_user.room_id', 'users.id', 'users.name', 'users.email')
        ->where('room_user.room_id', $room_id)
        ->distinct()->get();
    }

    public function getUserGroupChats($user_id) {
        return DB::table('room_user')
        ->join('rooms', 'room_user.room_id', '=', 'rooms.id')
        ->select('rooms.id', 'rooms.name')
        ->where('room_user.user_id', $user_id)
        ->distinct()->get();
    }

    public function getUserGroupChatsWithUsers($user_id) {
        return DB::table('room_user')
        ->join('rooms', 'room_user.room_id', '=', 'rooms.id')
        ->join('users', 'room_user.user_id', '=', 'users.id')
        ->select('rooms.id', 'rooms.name', DB::raw("(GROUP_CONCAT(users.name SEPARATOR ', ')) as user_names"))
        ->where('room_user.user_id', $user_id)
        ->groupBy('rooms.id')
        ->get();
    }

    public function storeGroupChatMessage($room_id, $user_id, $content) {
        return Message::create([
            'user_id' => $user_id,
            'room_id' => $room_id,
            'content' => $content
        ]);
    }
}