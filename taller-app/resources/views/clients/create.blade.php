<x-app-layout>
    @include('sweetalert::alert')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Client
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
                    <form method="POST" action="/clients">
                        @csrf
                        <label class="mt-5">First Name:</label>
                        <input class="mt-5" type="text" name="first_name" value="{{ old('first_name') }}" required></br>
                        <label class="mt-5">Last Name:</label>
                        <input class="mt-5" type="text" name="last_name" value="{{ old('last_name') }}" required></br>
                        <label class="mt-5">Phone:</label>
                        <input class="mt-5" type="tel" name="phone" placeholder="####-####" pattern="[0-9]{4}-[0-9]{4}" value="{{ old('phone') }}" required></br>
                        <label class="mt-5">Email:</label>
                        <input class="mt-5" type="email" name="email" value="{{ old('email') }}" required></br>
                        <button class="mt-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                        <a class="mt-5 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="/clients">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
