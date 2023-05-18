<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Helpers\APIHelpers;
use Validator, Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'asc')->get();

        $productsDB = collect();

        if ($products) {

            foreach ($products as $product) {
                $listaDevolver = [
                    'id' => $product->id,
                    'id_subcategory' => $product->id_category,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'uuid' => $product->uuid,
                    'image' => env('IMAGE_URL') . "/storage/imagenes/" . $product->image,
                    'imageID' => $product->image,
                ];

                $productsDB->push($listaDevolver);
            }

            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Productos encontrados con éxito', $productsDB);

            return response()->json($respuesta, 200);
        } else {
            $respuesta = APIHelpers::createAPIResponse(true, 500, 'Productos encontrados con éxito', $productsDB);

            return response()->json($respuesta, 200);
        }
    }

    public function indexCarta($nombre)
    {
        if ($nombre != "null" && $nombre != "") {
            $products = Product::where('name', 'like', '%' . $nombre . '%')->orderBy('created_at', 'asc')->get();
        } else {
            $products = Product::orderBy('created_at', 'asc')->get();
        }

        $productsDB = collect();

        if ($products) {

            foreach ($products as $product) {
                $listaDevolver = [
                    'id' => $product->id,
                    'id_category' => $product->id_category,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'uuid' => $product->uuid,
                    'image' => env('IMAGE_URL') . "/storage/imagenes/" . $product->image,
                    'imageID' => $product->image,
                ];

                $productsDB->push($listaDevolver);
            }

            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Productos encontrados con éxito', $productsDB);

            return response()->json($respuesta, 200);
        } else {
            $respuesta = APIHelpers::createAPIResponse(true, 500, 'Productos encontrados con éxito', $productsDB);

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
            'nombre' => 'required | unique:App\Models\Product,name',
            'descripcion' => 'required',
            'precio' => 'required',
        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'nombre.unique' => 'Ya existe un producto registrado con el nombre ingresado',
            'descripcion.required' => 'La descripción es requerida',
            'precio.required' => 'El precio es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);
        }

        $form = $request->all();
        $form['uuid'] = (string) Str::uuid();

        if ($request->hasFile('imagen')) {
            // $form['imagen'] = time() . '_' . $request->file('imagen')->getClientOriginalName();
            // $request->file('imagen')->storeAs('imagenes', $form['imagen']);

            $form['imagen'] = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->storeAs('imagenes', $form['imagen']);

            $nombreGuardar = 'public/imagenes/' . $form['imagen'];
            // Storage::put($nombreGuardar, $request->file('imagen'));
            Storage::putFileAs('public/imagenes/', $request->file('imagen'), $form['imagen']);
        }

        $product = new Product();

        $product->id_category =  $form['idCategoria'];
        $product->name =  $form['nombre'];
        $product->description =  $form['descripcion'];
        $product->price =  $form['precio'];
        $product->uuid =  $form['uuid'];
        $product->stock =  $form['stock'];
        $product->image =  $form['imagen'];

        if ($product->save()) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Producto creado con éxito', $product);

            return response()->json($respuesta, 200);
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se pudo crear el producto', $validator->errors());

            return response()->json($respuesta, 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', '=', $id)->first();

        if ($product) {
            $producto = [
                'id' => $product->id,
                'id_category' => $product->id_category,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'uuid' => $product->uuid,
                'image' => env('IMAGE_URL') . "/storage/imagenes/" . $product->image,
                'imageID' => $product->image,
            ];

            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Producto encontrado', $producto);
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se encontró el producto', 'No se encontró el producto');
        }

        return $respuesta;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $rules = [
            'idCategoria' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'stock' => 'required',
        ];

        $messages = [
            'idCategoria.required' => 'La categoría es requerida',
            'nombre.required' => 'El nombre es requerido',
            'descripcion.required' => 'La descripción es requerida',
            'precio.required' => 'El precio es requerido',
            'stock.required' => 'El stock es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);
        }

        $form = $request->all();

        $form['uuid'] = (string) Str::uuid();

        
        $product = Product::where('id', '=', $id)->first();

        if ($product) {
            $product->id_category = $request->idCategoria;
            $product->name = $request->nombre;
            $product->description = $request->descripcion;
            $product->price = $request->precio;
            $product->stock = $request->stock;

            if ($request->hasFile('imagen')) {
                $form['imagen'] = time() . '_' . $request->file('imagen')->getClientOriginalName();
                $request->file('imagen')->storeAs('imagenes', $form['imagen']);
    
                $product->uuid =  $form['uuid'];
                $product->image =  $form['imagen'];
            }

            if ($product->save()) {
                $respuesta = APIHelpers::createAPIResponse(false, 200, 'Producto modificado con éxito', $product);
            }
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se encontró el producto', 'No se encontró el producto');
        }

        return $respuesta;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::destroy($id);
        
        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Producto eliminado con éxito', $product);

        return response()->json($respuesta, 200);
    }
}
