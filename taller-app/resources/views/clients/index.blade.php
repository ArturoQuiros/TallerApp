<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clients
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ $clients->links() }}
                    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="/clients/create">New Client</a>
                    <table class="table-auto min-w-full divide-y divide-gray-200 mt-6">
                        <thead class="bg-gray-50">
                        <tr>
                            <form method="GET">
                                <td>
                                    <input type="text" name="id" autofocus value="{{request()->get('id')}}">
                                </td>
                                <td>
                                    <input type="text" name="first_name" value="{{request()->get('first_name')}}">
                                </td>
                                <td>
                                    <input type="text" name="last_name" value="{{request()->get('last_name')}}">
                                </td>
                                <td>
                                    <input type="text" name="phone" value="{{request()->get('phone')}}">
                                </td>
                                <td>
                                    <input type="text" name="email" value="{{request()->get('email')}}">
                                </td>
                                <td>
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filter</button>
                                </td>
                            </form>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">Id</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">First Name</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">Last Name</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">Phone</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($clients as $client)
                        <tr>
                            <td class="px-6 py-2 whitespace-nowrap">{{$client->id}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$client->first_name}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$client->last_name}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$client->phone}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$client->email}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <a class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold px-4 rounded" href="/clients/{{$client->id}}/edit"><x-carbon-edit style="color:white; display:inline; padding-top:2px; padding-bottom:4px" class="h-6"/></a>
                                <a class="bg-red-500 hover:bg-red-700 text-white font-bold px-4 rounded" href="/clients/{{$client->id}}/delete">  X  </a>
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
