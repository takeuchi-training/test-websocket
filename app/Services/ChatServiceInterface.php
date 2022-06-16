<?php 

namespace App\Services;

use App\Repositories\ChatRepositoryInterface;

interface ChatServiceInterface {
    public function isUserInGroupChat($room_id, $user);
}