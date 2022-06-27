<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (Auth::user()->role === "admin")

                    {{ $users->links() }}
                    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="/register">New User</a>
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
                                    <input type="text" name="role" value="{{request()->get('role')}}">
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
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider">Is Active</th>
                            <th scope="col" class="px-6 py-4 text-left uppercase tracking-wider"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-2 whitespace-nowrap">{{$user->id}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$user->first_name}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$user->last_name}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$user->phone}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$user->email}}</td>
                            <td class="px-6 py-2 whitespace-nowrap">{{$user->role}}</td>
                            <td class="px-6 py-2 whitespace-nowrap"><input type="checkbox" name="is_active" {{$user->is_active ? 'checked' : ''}} disabled></td>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <a class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold px-4 rounded" href="/users/{{$user->id}}/edit"><x-carbon-edit style="color:white; display:inline; padding-top:2px; padding-bottom:4px" class="h-6"/></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="7">No data found 😥</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>

                    @else
                        <p>Oops, you are not an admin</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
