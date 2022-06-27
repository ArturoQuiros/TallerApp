<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Piece
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
                    <form method="POST" action="/pieces/{{$piece->id}}">
                        @csrf
                        @method('PUT')
                        <label class="mt-5">Description:</label>
                        <input class="mt-5" type="text" name="description" required value="{{$piece->description}}"></br>
                        <label class="mt-5">Quantity:</label>
                        <input class="mt-5" type="number" name="quantity" required value="{{$piece->quantity}}"></br>
                        <label class="mt-5">Cost:</label>
                        <input class="mt-5 mb-5" type="number" name="cost" required value="{{$piece->cost}}"></br>
                        <label>Is Active:</label>
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{$piece->is_active || old('is_active', 0) === 1 ? 'checked' : ''}}></br>
                        <button class="mt-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                        <a class="mt-5 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="/pieces">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
