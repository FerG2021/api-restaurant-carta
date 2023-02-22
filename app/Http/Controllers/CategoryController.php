<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Helpers\APIHelpers;
use Validator, Auth;
use Illuminate\Http\Request;



class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $categories = Category::orderBy('created_at', 'asc')->get();

        if ($categories) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Categorias encontradas con éxito', $categories);

            return response()->json($respuesta, 200);
        } else {
            $respuesta = APIHelpers::createAPIResponse(true, 200, 'Categorias encontradas con éxito', $categories);

            return response()->json($respuesta, 200);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
        //

        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = Subcategory::orderBy('created_at', 'desc')->get();

        if ($categories) {

            $arrayCategorySubcategory = collect();
            
            foreach ($categories as $category) {
                $arraySubcategory = collect();
                
                foreach ($subcategories as $subcategory) {
                    if ($category->id == $subcategory->id_category) {
                        $arraySubcategory->push($subcategory);
                    }
                }

                $listaDevolver = [
                    'idCategoria' => $category->id,
                    'categoria' => $category,
                    'subcategorias' => $arraySubcategory,
                ];

                $arrayCategorySubcategory->push($listaDevolver);
            }

            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Categorias encontradas con éxito', $arrayCategorySubcategory);

            return response()->json($respuesta, 200);
        } else {
            $respuesta = APIHelpers::createAPIResponse(true, 500, 'No se encontraron categorías disponibles', $categories);

            return response()->json($respuesta, 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
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

        $category = new Category();

        $category->name  = $request->nombre;
        $category->description  = $request->descripcion;

        if ($category->save()) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Categoría creada con éxito', $validator->errors());

            return response()->json($respuesta, 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::where('id', '=', $id)->first();

        if ($category) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Categoría encontrada', $category);
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se encontró la categoría', 'No se encontró la categoría');
        }

        return $respuesta;
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
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

        
        $category = Category::where('id', '=', $id)->first();

        if ($category) {
            $category->name = $request->nombre;
            $category->description = $request->descripcion;

            if ($category->save()) {
                $respuesta = APIHelpers::createAPIResponse(false, 200, 'Categoría modificada con éxito', $category);
            }
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se encontró la categoría', 'No se encontró la categoría');
        }

        return $respuesta;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::destroy($id);
        
        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Categoría eliminada con exito', $category);

        return response()->json($respuesta, 200);
    }
}
