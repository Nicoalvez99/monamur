<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Support\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SaveProjectRequest;
use Illuminate\Support\Facades\Storage;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->id;
        $totalProductos = Productos::where('user_id', '=', $user)->get();

        return view('productos.productos', [
            "totalProductos" => $totalProductos
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
    public function store(Productos $productos,  Request $request)
    {
        $userId = Auth::user()->id;
        $validateData = $request->validate([
            "codigo" => 'max:40',
            "nombre" => 'required',
            "descripcion" => 'required',
            "imagen" => 'required|mimes:jpg,jpeg,png',
            "talle" => 'required',
            "cantidad" => 'required|numeric',
            "descuento" => 'numeric',
            "precio" => 'required|numeric',
        ]);

        if ($request->hasFile("imagen")) {
            $file = $request->file("imagen");
            $destinationPath = 'images/productos/';
            $fileName = time() . "-" . $file->getClientOriginalName();
            $request->file('imagen')->move($destinationPath, $fileName);
            $nameFinal = $fileName;
        }

        //$precio = Number::format($validateData["precio"], locale: 'de');
        //dd($precio);
        $productos->create([
            "codigo" => $validateData["codigo"],
            "nombre" => $validateData["nombre"],
            "descripcion" => $validateData["descripcion"],
            "imagen" => $nameFinal,
            "talle" => $validateData["talle"],
            "cantidad" => $validateData["cantidad"],
            "descuento" => $validateData["descuento"],
            "precio" => $validateData["precio"],
            "user_id" => $userId
        ]);
        return redirect()->route("mis.productos")->with('status', 'Producto creado exitosamente');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Productos $productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('productos.edit', [
            'producto' => Productos::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Productos $productos)
    {
        //dd($request->nombre);
        $validateData = $request->validate([
            "codigo" => 'max:40',
            "nombre" => 'required',
            "descripcion" => 'required',
            "imagen" => 'required|mimes:jpg,jpeg,png',
            "talle" => 'required',
            "cantidad" => 'required|numeric',
            "descuento" => 'numeric',
            "precio" => 'required|numeric',
        ]);
        if ($request->hasFile('imagen')) {
            
            unlink('images/productos/' . $productos->imagen);

            $file = $request->file('imagen');
            $destinationPath = 'images/productos/';
            $fileName = time() . "-" . $file->getClientOriginalName();
            $request->file('imagen')->move($destinationPath, $fileName);
            $nameFinal = $fileName;


            $productos->update([
                "codigo" => $validateData["codigo"],
                "nombre" => $validateData["nombre"],
                "descripcion" => $validateData["descripcion"],
                "imagen" => $nameFinal,
                "talle" => $validateData["talle"],
                "cantidad" => $validateData["cantidad"],
                "descuento" => $validateData["descuento"],
                "precio" => $validateData["precio"],
            ]);
        } else {
            $productos->update([
                "codigo" => $validateData["codigo"],
                "nombre" => $validateData["nombre"],
                "descripcion" => $validateData["descripcion"],
                "talle" => $validateData["talle"],
                "cantidad" => $validateData["cantidad"],
                "descuento" => $validateData["descuento"],
                "precio" => $validateData["precio"],
            ]);
        }
        return redirect()->route('mis.productos')->with('status', 'Producto editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productos $productos)
    {
        //
    }
}
