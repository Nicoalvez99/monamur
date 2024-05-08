<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Categorias;
use Illuminate\Support\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->id;
        $totalProductos = Productos::where('user_id', '=', $user)->get();
        $categorias = Categorias::get('categoria');
        
        return view('productos.productos', [
            "totalProductos" => $totalProductos,
            "categorias" => $categorias
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
            "categoria" => 'required',
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
            "categoria" => $validateData["categoria"],
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
        $categorias = Categorias::get('categoria');

        return view('productos.edit', [
            'categorias' => $categorias,
            'producto' => Productos::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Productos $producto)
    {
        //dd($request->imagen);
        if ($request->hasFile('imagen')) {

            unlink('images/productos/' . $producto->imagen);

            $file = $request->file('imagen');
            $destinationPath = 'images/productos/';
            $fileName = time() . "-" . $file->getClientOriginalName();
            $request->file('imagen')->move($destinationPath, $fileName);
            $nameFinal = $fileName;

            $producto->update([
                "codigo" => $request->codigo,
                "nombre" => $request->nombre,
                "descripcion" => $request->descripcion,
                "imagen" => $nameFinal,
                "talle" => $request->talle,
                "cantidad" => $request->cantidad,
                "descuento" => $request->descuento,
                "precio" => $request->precio,
            ]);
        } else {
            //dd($request->nombre);
            $producto->update([
                "codigo" => $request->codigo,
                "nombre" => $request->nombre,
                "descripcion" => $request->descripcion,
                "talle" => $request->talle,
                "cantidad" => $request->cantidad,
                "descuento" => $request->descuento,
                "precio" => $request->precio,
            ]);
        }
        return redirect()->route('mis.productos')->with('status', 'Producto editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productos $producto)
    {
        unlink('images/productos/' . $producto->imagen);
        $producto->delete();
        return redirect()->route('mis.productos')->with('status', 'Producto eliminado');
    }
}
