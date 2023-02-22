<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Hash;
use App\Helpers\APIHelpers;
use Validator, Auth;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $subcategories = Subcategory::where('id_category', '=', $id)->get();

        if ($subcategories) {
            $arraySubcategory = collect();
            foreach ($subcategories as $subcategory) {
                $listaDevolver = [
                    'id' => $subcategory->id,
                    'id_category' => $subcategory->id_category,
                    'name' => $subcategory->name,
                    'description' => $subcategory->description,
                ];
    
                $arraySubcategory->push($listaDevolver);
            }
        } 

        $respuesta = APIHelpers::createAPIResponse(true, 200, 'Subcategorias encontrados', $arraySubcategory);

        return response()->json($respuesta, 200);
        

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
        $subcategories = Subcategory::all();

        if ($subcategories) {
            $arraySubcategory = collect();
            foreach ($subcategories as $subcategory) {
                $listaDevolver = [
                    'id' => $subcategory->id,
                    'id_category' => $subcategory->id_category,
                    'name' => $subcategory->name,
                    'description' => $subcategory->description,
                ];
    
                $arraySubcategory->push($listaDevolver);
            }
        } 

        $respuesta = APIHelpers::createAPIResponse(true, 200, 'Subcategorias encontrados', $arraySubcategory);

        return response()->json($respuesta, 200);
        

    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rules = [
            'idCategoria' => 'required',
            'nombre' => 'required',
        ];

        $messages = [
            'idCategoria.required' => 'El id de la categoría es requerido',
            'nombre.required' => 'El nombre es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);
        }

        $subcategory = new Subcategory();

        $subcategory->id_category  = $request->idCategoria;
        $subcategory->name  = $request->nombre;
        $subcategory->description  = $request->descripcion;

        if ($subcategory->save()) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Subcategoría creada con éxito', $validator->errors());

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
        $subcategory = Subcategory::where('id', '=', $id)->first();

        if ($subcategory) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Subcategoría encontrada', $subcategory);
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se encontró la subcategoría', 'No se encontró la subcategoría');
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
            'nombre' => 'required ',
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

        
        $subcategory = Subcategory::where('id', '=', $id)->first();

        if ($subcategory) {

            $subcategory->name = $request->nombre;
            $subcategory->description = $request->descripcion;

            if ($subcategory->save()) {
                $respuesta = APIHelpers::createAPIResponse(false, 200, 'Subcategoría modificada con éxito', $subcategory);
            }
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se encontró la subcategoría', 'No se encontró la subcategoría');
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
        $subcategory = Subcategory::destroy($id);
        
        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Subcategoría eliminada con exito', $subcategory);

        return response()->json($respuesta, 200);
    }
}
