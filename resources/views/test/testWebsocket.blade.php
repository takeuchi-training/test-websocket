<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hi {{ auth()->user()->name }}!
        </h2>
    </x-slot>

    <div class="container">
        <div class="row p-5">
            <div class="card col col-lg-8 offset-lg-2">
                <div class="card-body">
                  <h5 class="card-title">Room: {{ $room->name }}</h5>
                  <form id="testForm" action="/test-websocket" method="post">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" class="form-control" id="room_id" name="room_id" value="{{ $room->id }}">
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                        @error('message')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                      <div class="d-flex justify-content-center">
                          <button id="pushMessage" class="btn btn-primary">Submit</button>
                      </div>
                  </form>
                </div>
              </div>
        </div>

        <div class="row p-5">
            <div class="card col col-lg-8 offset-lg-2">
                <div class="card-body">
                  <h5 class="card-title">Messages</h5>
                  <div id="div-data" class="p-3">
                  @if ($messages !== null)
                      @foreach ($messages as $message)
                      <p><strong>{{ $message->user_name }}:</strong> {{ $message->content }}</p>
                      @endforeach
                  @endif
                </div>
                </div>
              </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    <script defer>
        let form = $('#testForm');

        $('#pushMessage').on('click', function(e) {
            e.preventDefault();

            axios.post('/test-websocket/' + $('[name=room_id]').val(), {
                user_id: $('[name=user_id]').val(),
                message: $('[name=message]').val(),
            });
        });

        // window.Echo.join('presence.chat.' + $('[name=user_id]').val())
        window.Echo.join('presence.group.chat.' + $('[name=room_id]').val())
            .here((users) => {
                console.log(users);
            })
            .joining((user) => {
                console.log("Joining: " + user.name);
            })
            .leaving((user) => {
                console.log("Leaving: " + user.name);
            })
            .error((error) => {
                console.error(error);
            })
            .listen('.chat', (e) => {
                console.log(e);
                $('#div-data').prepend("<p><strong>" + e.user.name + ":</strong> " + e.message + "</p>");
            })
    </script>
</x-app-layout>