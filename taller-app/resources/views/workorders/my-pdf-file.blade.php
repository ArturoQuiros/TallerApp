<!DOCTYPE html>
<html>
<head>
    <title>Workorder {{$workorder_id}}</title>
</head>

<body>
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
            
                        
                        <h1 class="font-bold text-3xl text-gray-800 leading-tight">
                        Workorder #{{ $workorder_id }} Details
                        </h1>
                        <hr>

                        <label class="mt-5">User: {{ $user_first_name }} {{ $user_last_name }} </label><br>
                        <label class="mt-5">Workorder State: {{ $state_description }} </label><br>
                        <label class="mt-5">Client: {{ $client_first_name }} {{ $client_last_name }}</label><br>


                        <h1 class="font-bold text-3xl text-gray-800 leading-tight">
                        Initial Diagnostic
                        </h1>
                        
                        <label class="mt-5">On {{ $car_initial_date }} </label><br>
                        <p>{{ $car_initial_state }} </p>
                        

                        <h1 class="font-bold text-3xl text-gray-800 leading-tight">
                        Reparation
                        </h1>

                        <h2 class="font-bold text-xl text-gray-800 leading-tight">
                        Auto Parts
                        </h2>

                        <table class="table-fixed">
                        @php
                            $reparationCost = 0;    
                        @endphp
                            <thead>
                                <tr>
                                <th>   Quantity   </th>
                                <th>   Description   </th>
                                <th>   Unit Price (USD)   </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pieces_workorder as $line)
                                {{ $reparationCost += $line->piece->cost * $line->piece->quantity }}
                                <tr>
                                <td>{{$line->quantity}}</td>
                                <td>{{$line->piece->description}}</td>
                                <td>{{$line->piece->cost}}</td>
                                </tr>
                                @empty
                                <tr>
                                <td>No pieces needed for reparation</td>
                                </tr>
                                @endforelse
                            </tbody>
                            </table>
                        <br>
                        <h2 class="mt-5">Reparation cost: <strong>${{ $reparationCost + $car_workorder_price }}<strong>  </h2>
                        
                        <h2 class="font-bold text-xl text-gray-800 leading-tight">
                        Photos
                        </h2>

                            @if (count($photos_workorder) > 0)
                                @for ($i = 0; $i < count($photos_workorder); $i++)
                                <div>
                                    <img src="{{public_path('firebase-temp-uploads').'/'.$photos_workorder[$i]->link}}" width="300" style="margin-bottom:10px">
                                </div>
                                @endfor
                            @else
                            <li>
                                No photos found
                            </li>
                            @endif

                        <br><hr>

                        <h1 class="font-bold text-3xl text-gray-800 leading-tight">
                        Final Diagnostic
                        </h1>

                        <label class="mt-5">On {{ $car_initial_date }} </label><br>
                        <p>{{ $car_final_state }} </p>

                        <h2 class="font-bold text-xl text-gray-800 leading-tight">
                        Client Sign
                        </h2>

                        @if ($client_sign)
                        <div>
                        <img src="{{public_path('firebase-temp-uploads').'/'.$client_sign}}" width="300"></br>
                        </div>
                        @else
                        <li>
                            No signature found
                        </li>
                        @endif

                        
                </div>
            </div>
        </div>
    </div>
</body>
</html>