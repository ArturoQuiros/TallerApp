<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User State
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

                    @if (Auth::user()->role === "admin")
                    <form method="POST" action="/users/{{$user->id}}">
                        @csrf
                        @method('PUT')
                        <label>Is Active:</label>
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{$user->is_active || old('is_active', 0) === 1 ? 'checked' : ''}}></br>
                        <button class="mt-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                        <a class="mt-5 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="/users">Cancel</a>
                    </form>
                    @else
                        <p>Oops, you are not an admin</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
