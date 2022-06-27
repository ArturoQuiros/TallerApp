<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Workorder
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/workorders">
                        @csrf
                        
                        <h1 class="font-bold text-3xl text-gray-800 leading-tight">
                        Initial Diagnostic
                        </h1>

                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        
                        <label class="mt-5">Client:</label>
                        <select class="mt-5" name="client_id">
                            @foreach ($clients as $client)
                            <option value="{{$client->id}}">
                                {{$client->first_name}} {{$client->last_name}}
                            </option>
                            @endforeach
                        </select></br>
                       
                        <label class="mt-5">Car Initial State:</label>
                        <textarea class="mt-5" name="car_initial_state" rows="4" cols="50"  required></textarea></br>

                        <label class="mt-5">Initial Date:</label>
                        <input class="mt-5" type="date" name="car_initial_date" required></br>

                        <label class="mt-5">Workorder State:</label>
                        <select class="mt-5" name="state_id">
                            @foreach ($states as $state)
                            <option value="{{$state->id}}">
                                {{$state->description}} 
                            </option>
                            @endforeach
                        </select></br>

                        <button class="mt-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                        <a class="mt-5 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="/workorders">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

                        
                        