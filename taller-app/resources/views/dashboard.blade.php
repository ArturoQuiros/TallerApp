
<x-app-layout>
    

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Dashboard
        </h2>
     
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.3.2/dist/echarts.min.js"></script>

       
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="font-regulat text-3xl text-gray-800 leading-tight">¡Hello!,  <strong> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} </strong> </h1>
                </div>
            </div>
            <br>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="display:none;">

                    <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">This is your workorders summary  </h1><br>
                        <div class="flex flex-row justify-center ">
                            @forelse($workorders as $workorder)
                            <div class="bg-emerald-200 w-1/4 h-28 text-center ml-12 mr-12" >
                            @foreach ($states as $state)
                                @if ($state->id === $workorder->state_id)
                                    <p>{{$state->description}}</p>
                                @endif
                            @endforeach
                            <h1 style="font-size:40pt"><strong>{{$workorder->count}}</strong></h1>
                            </div>
                            @empty
                            <h1 style="font-size:20pt"><strong>No workorders found 😥</strong></h1>
                            @endforelse
                        </div>
                    </div>
                </div>

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                            @forelse($workorders as $workorder)
                            <div id="container" style="height: 350%"></div>
                            @empty
                            <h1 style="font-size:20pt"><strong>No workorders found 😥</strong></h1>
                            @endforelse
                            <div>
                            <div>
                        </div>

                        <script type="text/javascript">
var dom = document.getElementById("container");
var myChart = echarts.init(dom);
var app = {};

var json_workorders = <?php echo json_encode($workorders); ?> ;
var json_states = <?php echo json_encode($states); ?> ; 

var option;

option = {
  title: {
    text: 'Workorders Summary',
    left: 'center'
  },
  tooltip: {
    trigger: 'item'
  },
  legend: {
    orient: 'vertical',
    left: 'left'
  },
  series: [
    {
      name: 'Workorder State',
      type: 'pie',
      radius: '50%',
      data: [],
      emphasis: {
        itemStyle: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        }
      }
    }
  ]
};

//Iterar sobre cada JSON del array que da la base de datos 
json_workorders.forEach((item)=> {
        //Al array de data, agregar cada uno de los JSON proveniente de la db con el formato adecuado
        json_states.forEach((item2)=> { 
            if (item.state_id == item2.id) {
                option.series[0].data.push({"value":item.count,"name":item2.description});
            }
        });
    });

if (option && typeof option === 'object') {
    myChart.setOption(option);
}

        </script>
</x-app-layout>

