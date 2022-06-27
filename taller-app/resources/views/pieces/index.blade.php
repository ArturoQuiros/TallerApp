<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pieces
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ $pieces->links() }}
                    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="/pieces/create">New Piece</a>
                    <table class="table-auto min-w-full divide-y divide-gray-200 mt-6">
                        <thead class="bg-gray-50">
                        <tr>
                            <form method="GET">
                                <td>
                                    <input type="text" name="id" autofocus value="{{request()->get('id')}}">
                                </td>
                                <td>
                                    <input type="text" name="description" value="{{request()->get('description')}}">
                                </td>
                                <td>
                                    <input type="number" name="quantity" value="{{request()->get('quantity')}}">
                                </td>
                                <td>
                                    <input type="number" name="cost" value="{{request()->get('cost')}}">
                                </td>
                                <td>
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filter</button>
                                </td>
                            </form>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">Id</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">Cost</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">is Active</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pieces as $piece)
                        <tr>
                            <td class="px-6 py-2 whitespace-nowrap">{{$piece->id}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$piece->description}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$piece->quantity}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$piece->cost}}</td>
                            <td class="px-6 py-2 whitespace-nowrap"><input type="checkbox" name="is_active" {{$piece->is_active ? 'checked' : ''}} disabled></td>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <a class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold px-4 rounded" href="/pieces/{{$piece->id}}/edit"><x-carbon-edit style="color:white; display:inline; padding-top:2px; padding-bottom:4px" class="h-6"/></a>
                                <a class="bg-red-500 hover:bg-red-700 text-white font-bold px-4 rounded" href="/pieces/{{$piece->id}}/delete">  X  </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="7">No data found 😥</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
