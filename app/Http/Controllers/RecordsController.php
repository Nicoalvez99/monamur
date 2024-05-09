<?php

namespace App\Http\Controllers;

use App\Models\Records;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexStock()
    {
        $user = Auth::user();
        $productos = Productos::where('user_id', '=', $user->id)->get();
        return view('historial', [
            "productos" => $productos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Records $records)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Records $records)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Records $records)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Records $records)
    {
        //
    }
}
