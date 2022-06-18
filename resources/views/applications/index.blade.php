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
                  <h5 class="card-title">Create new application</h5>
                  <form id="applicationForm" action="/applications" method="post">
                    @csrf
                      <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                        @error('content')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                      <div class="d-flex justify-content-center">
                          <button class="btn btn-primary">Submit</button>
                      </div>
                  </form>
                </div>
              </div>
        </div>

        <div class="row p-5">
            <div class="card col col-lg-8 offset-lg-2">
                <div class="card-body">
                  <h5 class="card-title">Applications</h5>
                  <div id="div-data" class="p-3">
                  @if ($applications !== null)
                      @foreach ($applications as $key => $application)
                        @php
                            switch($application->status) {
                                case 1:
                                    $applicationCssClass = 'bg-success';
                                    $applicationStatus = 'Approved';
                                    break;
                                case 2:
                                    $applicationCssClass = 'bg-danger';
                                    $applicationStatus = 'Denied';
                                    break;
                                default:
                                    $applicationCssClass = 'bg-warning';
                                    $applicationStatus = 'Pending';
                            }
                        @endphp

                      <div class="d-flex justify-content-between">
                        <h5>{{ $application->title }}  <span class="badge {{ $applicationCssClass }}">{{ $applicationStatus }}</span></h5>
                        <small>created at {{ $application->created_at }}</small>
                      </div>
                      <p>Content: {{ $application->content }}</p>
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