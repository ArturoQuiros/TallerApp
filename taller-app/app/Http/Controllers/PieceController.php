<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PieceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pieces = Piece::query()->orderBy('id');

        if ($request->has('id') && $request->id) {
            $pieces->where('id', $request->id);
        }

        if ($request->has('description') && $request->description) {
            $pieces->where('description', 'ilike', "%$request->description%");
        }

        if ($request->has('quantity') && $request->quantity) {
            $pieces->where('quantity', 'ilike', "%$request->quantity%");
        }

        if ($request->has('cost') && $request->cost) {
            $pieces->where('cost', 'ilike', "%$request->cost%");
        }

        return view('pieces.index', ['pieces' => $pieces->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pieces.create');
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
            'description' => 'required',
            'quantity' => 'required',
            'cost' => 'required',
        ]);

        Piece::create($request->all());
        alert()->success('Successfull','The piece has been saved');
        return redirect('/pieces');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $piece = Piece::find($id);
        return view('pieces.edit', ['piece' => $piece]);
    }

    public function delete($id)
    {
        $piece = Piece::find($id);
        return view('pieces.delete', ['piece' => $piece]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'quantity' => 'required',
            'cost' => 'required',
            'is_active' => 'required'
        ]);
        $piece = Piece::find($request->id);
        $piece->update($request->all());
        alert()->success('Successfull','The piece has been updated');
        return redirect('/pieces');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Piece::destroy($id);
            alert()->success('Successfull','The piece has been deleted');
            return redirect('/pieces');
        } catch (\Throwable $th) {
            alert()->error('Error','Unable to delete this piece because it is connected to workorders');
            return redirect('/pieces');
        }
    }
}
