{{-- <x-app-layout>
    <div class="container">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Test WebSocket Input</h5>
              <form action="/test-websocket" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                  </div>
                  <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                  </div>
                  <button class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
    </div>
</x-app-layout> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
                        {{-- <label for="name" class="form-label">Name</label> --}}
                        <input type="hidden" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
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
                  <div id="div-data" class="p-3"></div>
                </div>
              </div>
        </div>
    </div>

    <script src='./js/app.js'></script>
    <script>
        let form = $('#testForm');

        $('#pushMessage').on('click', function(e) {
            e.preventDefault();

            axios.post('/api/test-websocket', {
                name: $('[name=name]').val(),
                message: $('[name=message]').val(),
            });
        });

        window.Echo.channel('send-messages')
                .listen('.chat', (e) => {
            console.log(e);
            $('#div-data').append("<p><strong>" + e.name + ":</strong> " + e.message + "</p>");
        })
    </script>
</body>
</html>