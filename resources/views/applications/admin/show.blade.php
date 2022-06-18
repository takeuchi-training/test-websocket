<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hi {{ auth()->user()->name }} from {{ auth()->user()->department->name }} department!
        </h2>
    </x-slot>

    <div class="container">
        <div class="row p-5">
            <div class="card col col-lg-8 offset-lg-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">{{ $application->title }}</h5>
                        <small>Created at {{ $application->created_at }}</small>
                    </div>
                  <p><strong>From employee: {{ $application->user_name }}</strong></p>
                  <p>Content: {{ $application->content }}</p>
                  <div class="d-flex justify-content-center">
                    <form method="POST" action="/admin/applications/{{ $application->id }}/approve">
                        @csrf
                        <button><i class="bi bi-check-lg text-success h3"></i></button>
                    </form>
                    <form method="POST" action="/admin/applications/{{ $application->id }}/deny">
                        @csrf
                        <button><i class="bi bi-x-lg text-danger h3 ms-5"></i></button>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
</x-app-layout>