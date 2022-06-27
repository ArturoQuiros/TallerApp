<?php

namespace App\Http\Controllers;

use App\Models\Workorder;
use App\Models\WorkorderState;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $workorders = Workorder::query()->select('state_id',Workorder::raw('count(state_id)'))->where('user_id', Auth::user()->id)->groupBy('state_id')->get();
        $states = WorkorderState::query()->select('id','description')->get();
        /*falta separar a los del user*/
        /*$workorders->where('user_id', Auth::user()->id);*/
        return view('dashboard', ['workorders' => $workorders, 'states' => $states] );
    }

}