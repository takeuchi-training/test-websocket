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
                  <h3>Welcome {{ auth()->user()->name }}!</h3>
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
                                  {{-- <span class="badge bg-danger">4</span>
                                  </span> --}}
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
</body>
</html>