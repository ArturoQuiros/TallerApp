<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pieces for Workorder {{$workorder->id}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="/workorders/{{$workorder->id}}/pieces_list">
                        @csrf
                        <input type="hidden" name="workorder_id" value="{{$workorder->id}}">
                        <label>Add Piece:</label>
                        <select name="piece_id">
                            @foreach ($pieces as $piece)
                            <option value="{{$piece->id}}">
                                {{$piece->description}} ({{$piece->quantity}})
                            </option>
                            @endforeach
                        </select>
                        <input type="number" name="quantity" required value="1">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                        <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="/workorders/{{$workorder->id}}/edit">Cancel</a>
                    </form>
                    <div class="mt-6">
                        <label>Pieces:</label></br></br>
                    </div>
                    <ul class="">
                        @forelse ($pieces_workorder as $line)
                        <li class="flex mt-2">
                            <div class="mr-2">
                                <form method="POST" action="/workorders/{{$workorder->id}}/pieces_list/{{$line->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold px-4 rounded">x</button>
                                </form>
                            </div>
                            <div>
                                {{$line->quantity}} of {{$line->piece->description}}
                            </div></br>
                        </li>
                        @empty
                        <li>
                            No pieces found 😥
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
