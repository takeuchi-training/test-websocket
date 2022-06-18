<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Chat Rooms') }}
      </h2>
  </x-slot>

  <div class="container">
    <div class="row p-5">
        <div class="card col col-lg-8 offset-lg-2">
            <div class="card-body">
              <h5 class="card-title">Your chat rooms</h5>
              
              <div class="card">
                <ul class="list-group list-group-flush">
                  @if ($rooms !== null)
                      @foreach ($rooms as $room)
                      <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                          <p><strong>{{ $room->name }}</strong></p>
                          <a href="/test-websocket/{{ $room->id }}" class="btn btn-sm btn-primary position-relative">
                              Inbox
                              <span class="badge bg-danger">4</span>
                              </span>
                            </a>
                        </div>
                      <small>Group's users: {{ $roomUsers->filter(function($usersroom) use($room) {
                        return $usersroom->room_id === $room->id;
                      })->map(fn($user) => $user->name)->implode(', ') }}</small>
                      </li>
                      @endforeach
                  @endif
                </ul>
              </div>
            </div>
          </div>
    </div>
</div>
</x-app-layout>
