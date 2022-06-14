<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
                <div id="div-data" class="p-3"></div>
            </div>
        </div>
    </div>
    
    <script src='./js/app.js'></script>

    {{-- <script>
        window.Echo.channel('event-triggered')
                .listen('GetRequestEvent', (e) => {
            console.log(e);
            $('#div-data').append("<p>" + e.message + "</p>");
        })
    </script> --}}

    <script>
        window.Echo.channel('send-messages')
                .listen('SendMessageEvent', (e) => {
            console.log(e);
            $('#div-data').append("<p><strong>" + e.name + ":</strong> " + e.message + "</p>");
        })
    </script>
</x-app-layout>
