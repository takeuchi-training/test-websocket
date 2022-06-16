<?php

namespace Tests\Unit;

use App\Models\Room;
use App\Models\RoomUser;
use App\Models\User;
use App\Services\ChatServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatServiceTest extends TestCase
{
    use RefreshDatabase;

    private $chatService;

    public function setUp() : void {
        parent::setUp();
        $this->chatService = $this->app->make(ChatServiceInterface::class);
    }

    public function test_user_belong_to_group_chat() {
        $room = Room::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();
        RoomUser::create([
            'user_id' => $user1->id,
            'room_id' => $room->id,
        ]);
        RoomUser::create([
            'user_id' => $user2->id,
            'room_id' => $room->id,
        ]);
        RoomUser::create([
            'user_id' => $user3->id,
            'room_id' => $room->id,
        ]);

        $this->assertTrue($this->chatService->isUserInGroupChat($room->id, $user1->id));
        $this->assertTrue($this->chatService->isUserInGroupChat($room->id, $user2->id));
        $this->assertTrue($this->chatService->isUserInGroupChat($room->id, $user3->id));
    }
}
