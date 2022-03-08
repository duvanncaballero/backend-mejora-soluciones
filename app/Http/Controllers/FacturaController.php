<?php

namespace App\Http\Controllers;

use App\Models\Configuracion\Resolucion;
use App\Models\Factura\DetalleFactura;
use App\Models\Factura\Factura;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Factura::all()->toArray());
    }

    public function getById(Request $request)
    {
        return response()->json(Factura::with('detalle')->find($request->get('factura'))->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $return = ['code' => 200, 'success' => true, 'message' => 'Los datos se han guardado correctamente.'];

        try {
            // Validation Data
            $validator = Validator::make($request->all(), [
                'nitEmisor'             => 'required|numeric|digits_between:6,9',
                'emisor'                => 'required|string|max:50',
                'nitCliente'            => 'required|numeric|digits_between:6,10',
                'cliente'               => 'required|string|max:50',

                'detalle.*.articulo'    => 'required|string|max:25',
                'detalle.*.impuesto'    => 'numeric',
                'detalle.*.valor'       => 'required|numeric',
                'detalle.*.cantidad'    => 'required|numeric',
                'detalle.*.total'       => 'required|numeric',
            ]);

            if(!$validator->passes())
            {
                $return['success'] = false;
                $return['message'] = json_decode($validator->errors());
                return response()->json($return, 422);
            }

            $resolucion = Resolucion::first();
            $prefijo = $resolucion->prefijo;
            $consecutivo = $resolucion->consecutivo ++;
            $resolucion->save();

            $factura = new Factura();
            $factura->prefijo = $prefijo;
            $factura->consecutivo = $consecutivo;
            $factura->fecha = Carbon::now()->format('Y-m-d');
            $factura->hora = Carbon::now()->format('h:m:s');
            $factura->nit_emisor = $request->get('nitEmisor');
            $factura->emisor = $request->get('emisor');
            $factura->nit_cliente = $request->get('nitCliente');
            $factura->cliente = $request->get('cliente');
            $factura->total = 0;
            $factura->save();

            $total = 0;
            foreach ($request->get('detalle') as $key => $value) 
            {
                $detalle = new DetalleFactura();
                $detalle->factura_id = $factura->id;
                $detalle->articulo = $value['articulo'];
                $detalle->valor_unitario = $value['valor'];
                $detalle->valor_impuesto = $value['impuesto'];
                $detalle->cantidad = $value['cantidad'];
                $detalle->valor_total = ($value['valor']+$value['impuesto'])*$value['cantidad'];
                $detalle->save();

                $total += $detalle->valor_total;
            }

            //actualizar el valor total
            $factura = Factura::find($factura->id);
            $factura->total = $total;
            $factura->save();

        } catch (\Exception $e) {
            $return['success'] = false;
            $return['code'] = 422;
            $return['message'] = $e->getMessage();
        }

        return response()->json($return, $return['code']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $return = ['code' => 200, 'success' => true, 'message' => 'Los datos se han editado correctamente.'];

        try {
            // Validation Data
            $validator = Validator::make($request->all(), [
                'nitEmisor'             => 'required|numeric|digits_between:6,9',
                'emisor'                => 'required|string|max:50',
                'nitCliente'            => 'required|numeric|digits_between:6,10',
                'cliente'               => 'required|string|max:50',

                'detalle.*.articulo'    => 'required|string|max:25',
                'detalle.*.impuesto'    => 'numeric',
                'detalle.*.valor'       => 'required|numeric',
                'detalle.*.cantidad'    => 'required|numeric',
                'detalle.*.total'       => 'required|numeric',
            ]);

            if(!$validator->passes())
            {
                $return['success'] = false;
                $return['message'] = json_decode($validator->errors());
                return response()->json($return, 422);
            }

            $factura = Factura::find($request->get('id'));
            $factura->nit_emisor = $request->get('nitEmisor');
            $factura->emisor = $request->get('emisor');
            $factura->nit_cliente = $request->get('nitCliente');
            $factura->cliente = $request->get('cliente');
            $factura->total = 1;
            $factura->save();

            $total = 0;
            DetalleFactura::where('factura_id', $request->get('id'))->delete();
            foreach ($request->get('detalle') as $key => $value) 
            {
                $detalle = new DetalleFactura();
                $detalle->factura_id = $factura->id;
                $detalle->articulo = $value['articulo'];
                $detalle->valor_unitario = $value['valor'];
                $detalle->valor_impuesto = $value['impuesto'];
                $detalle->cantidad = $value['cantidad'];
                $detalle->valor_total = ($value['valor']+$value['impuesto'])*$value['cantidad'];
                $detalle->save();
                
                $total += $detalle->valor_total;
            }

            //actualizar el valor total
            $factura = Factura::find($factura->id);
            $factura->total = $total;
            $factura->save();

        } catch (\Exception $e) {
            $return['success'] = false;
            $return['code'] = 422;
            $return['message'] = $e->getMessage();
        }

        return response()->json($return, $return['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($factura)
    {
        $return = ['code' => 200, 'success' => true, 'message' => 'Los datos se han eliminado correctamente.'];

        try {
            DetalleFactura::where('factura_id', $factura)->delete();
            Factura::find($factura)->delete();
        } catch (\Exception $e) {
            $return['success'] = false;
            $return['code'] = 422;
            $return['message'] = $e->getMessage();
        }

        return response()->json($return, $return['code']);
    }
}
