<?php

namespace App\Http\Controllers;

use App\Models\Records;
use App\Models\Chart;
use Carbon\Carbon;
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

    public function indexCharts(){
        $user = Auth::user();
        $chartTotal = Chart::where('user_id', '=', $user->id)->sum('total');

        $ventasPorDia = Chart::where('user_id', '=', $user->id)
            ->whereBetween('created_at', [now()->subWeek(), now()]) // Filtrar por la última semana
            ->selectRaw('DAYOFWEEK(created_at) as dia_semana, COUNT(*) as cantidad_ventas')
            ->groupBy('dia_semana')
            ->orderBy('dia_semana')
            ->get();

            foreach ($ventasPorDia as $venta) {
                // Mapa de día de la semana a su nombre
                $nombresDias = [
                    1 => 'domingo',
                    2 => 'lunes',
                    3 => 'martes',
                    4 => 'miércoles',
                    5 => 'jueves',
                    6 => 'viernes',
                    7 => 'sábado',
                ];
    
                // Obtener el nombre del día
                $nombreDia = $nombresDias[$venta->dia_semana];
    
                // Almacenar en el arreglo asociativo
                $ventasPorDiasSemana[$nombreDia] = $venta->cantidad_ventas;
            }
        return view('charts', [
            "totalHistorial" => $chartTotal,
            "ventasPorDiasSemana" => $ventasPorDiasSemana
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
