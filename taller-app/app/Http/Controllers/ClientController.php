<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::query()->orderBy('id');

        if ($request->has('id') && $request->id) {
            $clients->where('id', $request->id);
        }

        if ($request->has('first_name') && $request->first_name) {
            $clients->where('first_name', 'ilike', "%$request->first_name%");
        }

        if ($request->has('last_name') && $request->last_name) {
            $clients->where('last_name', 'ilike', "%$request->last_name%");
        }

        if ($request->has('phone') && $request->phone) {
            $clients->where('phone', 'ilike', "%$request->phone%");
        }

        if ($request->has('email') && $request->email) {
            $clients->where('email', 'ilike', "%$request->email%");
        }

        return view('clients.index', ['clients' => $clients->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:clients'
        ]);

        try {
            Client::create($request->all());
            alert::success('Successfull','The client has been saved');
            return redirect('/clients');
        } catch (\Throwable $th) {
            alert()->error('Error','That email is already registered for a client');
            return back()->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);
        return view('clients.edit', ['client' => $client]);
    }

    public function delete($id)
    {
        $client = Client::find($id);
        return view('clients.delete', ['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email' 
        ]);
        
        try {
            $client = Client::find($request->id);
            $client->update($request->all());
            alert()->success('Successfull','The client has been updated');
            return redirect('/clients');
        } catch (\Throwable $th) {
            alert()->error('Error','That email is already registered for a client');
            return back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Client::destroy($id);
        alert()->success('Successfull','The client has been deleted');
        return redirect('/clients');
        } catch (\Throwable $th) {
            alert()->error('Error','Unable to delete this client because he/she is connected to workorders');
            return redirect('/clients');
        }
    }
}
