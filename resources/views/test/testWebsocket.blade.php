<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.0.0-alpha.1/axios.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row p-5">
            <div class="card col col-lg-8 offset-lg-2">
                <div class="card-body">
                  <h5 class="card-title">Test WebSocket Input</h5>
                  <form id="testForm" action="/test-websocket" method="post">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" class="form-control" id="room_id" name="room_id" value="{{ $room_id }}">
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
    <script>
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
</body>
</html>