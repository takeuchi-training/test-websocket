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
                  <h5 class="card-title">Applications</h5>
                  <div id="div-data" class="p-3">
                  @if ($applications !== null)
                      @foreach ($applications as $key => $application)

                      <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-start">
                            <h5>{{ $application->title }}</h5>
                            @switch($application->status)
                                @case(2)
                                    <span class="badge bg-danger ms-1">Denied</span>
                                    @break
                                @case(1)
                                    <span class="badge bg-success ms-1">Approved</span>
                                    @break
                                @default
                                <a class="ms-1" href="/admin/applications/{{ $application->id }}">
                                <i class="bi bi-box-arrow-in-up-right"></i>
                                </a>
                            @endswitch
                        </div>
                        <small>created at {{ $application->created_at }}</small>
                      </div>
                      {{-- <p>Content: {{ $application->content }}</p> --}}
                      <strong>From employee: {{ $application->user_name }}</strong>
                      @if ($key !== array_key_last($applications->toArray()))
                          <hr>
                      @endif                      
                      @endforeach
                  @endif
                </div>
                </div>
              </div>
        </div>
    </div>
</x-app-layout>