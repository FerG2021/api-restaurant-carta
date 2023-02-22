<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Table;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Helpers\APIHelpers;
use Validator, Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request
     */
    public function create(Request $request)
    {
        $rules = [
            'arrayOrden' => 'required',
            'idMesa' => 'required',
            'precio' => 'required',
            'estado' => 'required',
        ];

        $messages = [
            'arrayOrden.required' => 'El array de orden es requerido',
            'idMesa.required' => 'El id de la mesa es requerido',
            'precio.required' => 'El precio es requerido',
            'estado.required' => 'El estado de la orden es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);
        }

        // $arrProductosRecibidos = json_decode($request->arrayProductosAComprarEnviar);

        $order = new Order();

        $order->id_table = $request->idMesa;
        $order->price = $request->precio;
        $order->state = $request->estado;

        
        if ($order->save()) {
            
            $arrProductoOrdenRecibido = json_decode($request->arrayOrden);

            foreach ($arrProductoOrdenRecibido as $itemProductoOrden) {

                $order = Order::orderBy('created_at', 'desc')->first();

                $orderProduct = new OrderProduct();

                $orderProduct->id_order = $order->id;
                $orderProduct->id_product = $itemProductoOrden->id;
                $orderProduct->name = $itemProductoOrden->name;
                $orderProduct->detail = $itemProductoOrden->description;
                $orderProduct->cant = $itemProductoOrden->cantidad;

                $orderProduct->save();

            }

            $table = Table::where('id', '=', $request->idMesa)->first();

            $table->state = 'Ocupada';

            if($table->save()){
                $respuesta = APIHelpers::createAPIResponse(false, 200, 'Orden generada con éxito', $order);

                return response()->json($respuesta, 200);
            }
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se pudo generar la orden ', $validator->errors());

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
     * @param  \App\Models\Order  $order
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $table = Table::where('id', '=', $id)->first();

        if ($table) {

            $order = Order::where('id', '=', $table->id)->where('state', '=', 'Comenzada')->first();

            if ($order) {
                $orderProducts = OrderProduct::where('id_order', '=', $order->id_table)->get();

                if ($orderProducts) {
                    $arrayProducts = collect();

                    foreach ($orderProducts as $orderProduct) {
                        $product = Product::where('id', '=', $orderProduct->id_product)->first();

                        $product = [
                            'productOrder' => $orderProduct,
                            'productDetail' => $product,
                        ];

                        $arrayProducts->push($product);

                    }
                }
                
            }

            $tableOrderObject = [
                'table' => $table,
                'order' => $order,
                'orderProducts' => $arrayProducts,
            ];

            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Mesa encontrada', $tableOrderObject);
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se encontró la mesa', 'No se encontró la mesa');
        }

        return $respuesta;
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
