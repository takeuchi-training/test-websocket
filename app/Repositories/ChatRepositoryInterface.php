<?php 

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Support\Facades\DB;

interface ChatRepositoryInterface {
    public function getChatRoom($room_id);
    public function getGroupChatMessages($room_id);
    public function getGroupChatUsers($room_id);
    public function getUserGroupChats($user_id);
    public function storeGroupChatMessage($room_id, $user_id, $content);
    public function getUserGroupChatsWithUsers($roomIds);
}