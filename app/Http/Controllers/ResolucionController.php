<?php

namespace App\Http\Controllers;

use App\Models\Configuracion\Resolucion;
use Illuminate\Http\Request;

class ResolucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Resolucion::first()->toArray());
    }
}
