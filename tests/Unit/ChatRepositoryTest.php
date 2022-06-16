<?php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\Room;
use App\Models\RoomUser;
use App\Models\User;
use App\Repositories\ChatRepositoryImpl;
use App\Repositories\ChatRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $chatRepository;

    public function setUp() : void {
        parent::setUp();
        $this->chatRepository = $this->app->make(ChatRepositoryImpl::class);
    }

    public function test_get_group_chat_messages() {
        $room = Room::factory()->create();
        $user = User::factory()->create();
        $message = Message::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'content' => "Testing"
        ]);

        $result = $this->chatRepository->getGroupChatMessages($room->id);
        $messageResult = $result[0];

        $this->assertSame($message->content, $messageResult->content, "Message content mismatch.");
    }

    public function test_get_chat_room() {
        $room = Room::factory()->create();
        $roomResult = $this->chatRepository->getChatRoom($room->id);
        $this->assertSame($room->name, $roomResult->name, "Room's name mismatch.");
    }

    public function test_get_group_chat_users() {
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

        $result = $this->chatRepository->getGroupChatUsers($room->id);
        $userNames = $result->map(fn($user) => $user->name);

        $this->assertTrue($userNames->contains($user1->name));
        $this->assertTrue($userNames->contains($user2->name));
        $this->assertTrue($userNames->contains($user3->name));
    }

    public function test_get_user_group_chats() {
        $user = User::factory()->create();
        $room1 = Room::factory()->create();
        $room2 = Room::factory()->create();
        RoomUser::create([
            'user_id' => $user->id,
            'room_id' => $room1->id,
        ]);
        RoomUser::create([
            'user_id' => $user->id,
            'room_id' => $room2->id,
        ]);

        $result = $this->chatRepository->getUserGroupChats($user->id);
        $roomNames = $result->map(fn($room) => $room->name);

        $this->assertTrue($roomNames->contains($room1->name));
        $this->assertTrue($roomNames->contains($room2->name));
    }
}
