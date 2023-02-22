<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Helpers\APIHelpers;
use Validator, Auth;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;

use PDF;
use QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $tables = Table::orderBy('created_at', 'asc')->get();

        if ($tables) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Mesas encontradas con éxito', $tables);

            return response()->json($respuesta, 200);
        } else {
            $respuesta = APIHelpers::createAPIResponse(true, 500, 'No se encontraron mesas', $tables);

            return response()->json($respuesta, 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rules = [
            'nombre' => 'required',
        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);
        }

        $table = new Table();

        $table->name  = $request->nombre;
        $table->state  = 'Habilitada';

        if ($table->save()) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Mesa creada con éxito', $validator->errors());

            return response()->json($respuesta, 200);
        }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $table = Table::where('id', '=', $id)->first();

        if ($table) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Mesa encontrada', $table);
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se encontró la mesa', 'No se encontró la mesa');
        }

        return $respuesta;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request
     */
    public function edit($id, Request $request)
    {
        $rules = [
            'estado' => 'required ',
        ];

        $messages = [
            'estado.required' => 'El estado es requerido',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);
        }

        
        $table = Table::where('id', '=', $id)->first();

        if ($table) {
            $table->state = $request->estado;

            if ($table->save()) {
                $respuesta = APIHelpers::createAPIResponse(false, 200, 'Estado de la mesa modificado con éxito', $table);
            }
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se encontró la mesa', 'No se encontró la mesa');
        }

        return $respuesta;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = Table::destroy($id);
        
        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Mesa eliminada con exito', $table);

        return response()->json($respuesta, 200);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generarQR($id)
    {
        // $qr = \QrCode::size(300)->generate('https://techvblogs.com/blog/generate-qr-code-laravel-9');

        $table = Table::where('id', '=', $id)->first();

        $urlQR = 'http://balanceado.com.ar?mesa=' . $id;
        $qr = \QrCode::size(300)->style('round')->generate($urlQR);


        // METODO PARA GENERAR, GUARDAR Y MOSTRAR EL PDF
        $today = Carbon::now()->format('d/m/Y'); // paso datos
        // $pdf = \PDF::loadView('ejemplo',compact('today', 'saleDB', 'saleProductDB'));
        $pdf = \PDF::loadView('ejemplo',compact('today', 'qr', 'table'));
        $content = $pdf->download()->getOriginalContent();
        $nombreGuardar = 'public/csv/' . time() . '_' . 'ejemplo.pdf';
        Storage::put($nombreGuardar, $content) ;

        // $saleDB = Sale::where('id', '=', $id)->first();

        // if ($saleDB) {
        //     if ($saleDB->urlpdf == null) {
        //         $saleDB->urlpdf = 'storage/'.$nombreGuardar;
        //         $saleDB->save();
        //         $urlEnviar = env('IMAGE_URL'). '/' . 'storage/' . $nombreGuardar;
        //     } else {
        //         $urlEnviar = env('IMAGE_URL'). '/' .$saleDB->urlpdf;
        //     }
        // }

        $urlEnviar = env('IMAGE_URL'). '/' . 'storage/' . $nombreGuardar;

        $url = env('IMAGE_URL') . Storage::url($nombreGuardar);
 

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'PDF generado con éxito', $urlEnviar);

        return $respuesta;
    }
}
