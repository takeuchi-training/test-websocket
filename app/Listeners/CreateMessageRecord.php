<?php

namespace App\Listeners;

use App\Events\SendMessageEvent;
use App\Repositories\ChatRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateMessageRecord
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SendMessageEvent $event)
    {
        $chatRepository = app()->make(ChatRepositoryInterface::class);
        return $chatRepository->storeGroupChatMessage($event->room->id, $event->user->id, $event->message);
    }
}
