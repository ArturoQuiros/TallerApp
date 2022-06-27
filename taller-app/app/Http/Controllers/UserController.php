<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::query()->orderBy('id');

        if ($request->has('id') && $request->id) {
            $users->where('id', $request->id);
        }

        if ($request->has('first_name') && $request->first_name) {
            $users->where('first_name', 'ilike', "%$request->first_name%");
        }

        if ($request->has('last_name') && $request->last_name) {
            $users->where('last_name', 'ilike', "%$request->last_name%");
        }

        if ($request->has('phone') && $request->phone) {
            $users->where('phone', 'ilike', "%$request->phone%");
        }

        if ($request->has('email') && $request->email) {
            $users->where('email', 'ilike', "%$request->email%");
        }

        if ($request->has('role') && $request->role) {
            $users->where('role', 'ilike', "%$request->role%");
        }

        return view('users.index', ['users' => $users->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'is_active' => 'required'
        ]);
        $user = User::find($request->id);
        $user->update(['is_active' => $request->is_active]);
        alert()->success('Successfull','The user state has been updated');
        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
