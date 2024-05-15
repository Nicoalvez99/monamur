<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Compras;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\Auth;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $compras = Compras::where('user_id', '=', $user->id)->get();
        return view('ventas', [
            "compras" => $compras
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
        $user = Auth::user();
        $input = $request->input;
        $cantidad = $request->cantidad == "" ? 1 : intval($request->cantidad);
        $aProductos = Productos::where('user_id', '=', $user->id)->get();

        foreach($aProductos as $producto) {
            if($producto->codigo == $input || $producto->nombre == $input) {
                $precioDescuento = $producto->descuento > 0 ? $producto->precio - ($producto->precio * $producto->descuento / 100) : $producto->precio;
                Compras::create([
                    "codigo" => $producto->codigo,
                    "nombre" => $producto->nombre,
                    "cantidad" => $cantidad,
                    "precio" => $precioDescuento,
                    "stock" => $producto->cantidad,
                    "categoria" => $producto->categoria,
                    "precioTotal" => $precioDescuento * $cantidad,
                    "user_id" => $user->id
                ]);
            }
        }
        return redirect()->route('ventas');
    }

    /**
     * Display the specified resource.
     */
    public function show(Compras $compras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compras $compras)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compras $compras)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compras $compras, Chart $chart)
    {
        $user = Auth::user();
        $comprasUsuario = Compras::where('user_id', $user->id)->get();
        $aProductos = [];
        $totalCompra = 0;
        foreach($comprasUsuario as $compra) {
            $codigoProducto = $compra->codigo;
            $cantidadCompra = $compra->cantidad;

            $aProductos[] = $compra->cantidad > 1 ? $compra->nombre . "(" . $compra->cantidad . ")" : $compra->nombre;
            $totalCompra += $compra->precioTotal;

            $producto = Productos::where('codigo', $codigoProducto)->first();
            $producto->decrement('cantidad', $cantidadCompra);
        }

        $cadenaProductos = implode(', ', $aProductos);

        Chart::create([
            "aProductos" => $cadenaProductos,
            "total" => $totalCompra,
            "user_id" => $user->id
        ]);


        Compras::where('user_id', $user->id)->delete();

        return redirect()->route('ventas');
    }
}
