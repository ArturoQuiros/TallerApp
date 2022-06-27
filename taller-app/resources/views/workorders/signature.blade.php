<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Signature for Workorder {{$workorder->id}}
        </h2>

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
        <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
        <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

        <style>
            .kbw-signature { width: 100%; height: 200px;}
            #sig canvas{
                width: 100% !important;
                height: auto;
            }
        </style>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                

                <div class="container">

                    <div class="row">

                        <div class="col-md-6 offset-md-3 mt-5">

                            <div class="card">

                                <div class="card-header">

                                    <h5>Signature for Workorder {{$workorder->id}}</h5>

                                    <div>
                                        <img src="{{ $imgURL }}" class="img-fluid" width="500"></br>
                                    </div>

                                </div>

                                <div class="card-body">

                                        <form method="POST" action="/workorders/{{$workorder->id}}/signature">

                                            @csrf

                                            <div class="col-md-12">

                                                <input type="hidden" name="workorder_id" value="{{$workorder->id}}">
                                                <label class="" for="">Signature:</label>

                                                <br/>

                                                <div id="sig" ></div>

                                                <br/>

                                                <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>

                                                <textarea id="signature64" name="signed" style="display: none"></textarea>

                                            </div>

                                            <br/>

                                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                                            <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="/workorders/{{$workorder->id}}/edit">Cancel</a>

                                        </form>

                                </div>

                            </div>

                        </div>

                    </div>

                    </div>

                    <script type="text/javascript">

                        var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});

                        $('#clear').click(function(e) {

                            e.preventDefault();

                            sig.signature('clear');

                            $("#signature64").val('');

                        });

                    </script>
                    <br/>
                    <br/>
                    <br/>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
