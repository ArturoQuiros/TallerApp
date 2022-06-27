<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Delete Piece?
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="/pieces/{{$piece->id}}">
                        @csrf
                        @method('DELETE')
                        <p class="mb-6">
                            Are you sure you want to delete <strong>{{$piece->description}}</strong>?
                        </p>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Confirm</button>
                        <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="/pieces">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
