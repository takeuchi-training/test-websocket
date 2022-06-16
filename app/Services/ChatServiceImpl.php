<?php 

namespace App\Services;

use App\Repositories\ChatRepositoryInterface;

class ChatServiceImpl implements ChatServiceInterface {
    private $chatRepository;

    public function __construct() {
        $this->chatRepository = app()->make(ChatRepositoryInterface::class);
    }

    public function isUserInGroupChat($room_id, $user_id) {
        $users = $this->chatRepository->getGroupChatUsers($room_id);
        $userIds = $users->map(fn($user) => $user->id);

        return $userIds->contains($user_id);
    }
}