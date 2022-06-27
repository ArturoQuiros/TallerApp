<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Photos for Workorder {{$workorder->id}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" enctype="multipart/form-data" action="/workorders/{{$workorder->id}}/photos_list">
                        @csrf
                        <input type="hidden" name="workorder_id" value="{{$workorder->id}}">
                        <input type="hidden" name="link" value="{{time()*1000}}">
                        <label>Add Photo:</label>
                        <input type="file" class="form-control" name="photos[]" accept="image/*" multiple/>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                        <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="/workorders/{{$workorder->id}}/edit">Cancel</a>
                    </form>
                    <div class="mt-6">
                        <label>Photos:</label></br></br>
                    </div>
                    <ul class="">
                        @if (count($photos_workorder) > 0)
                            @for ($i = 0; $i < count($photos_workorder); $i++)
                            <li class="flex mt-2">
                                <div class="mr-2">
                                    <form method="POST" action="/workorders/{{$workorder->id}}/photos_list/{{$photos_workorder[$i]->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold px-4 rounded">x</button>
                                    </form>
                                </div>
                                <div>
                                    <img src="{{ $images[$i] }}" class="img-fluid" width="400"></br>
                                </div>
                            </li>
                            @endfor
                        @else
                        <li>
                            No photos found 😥
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
