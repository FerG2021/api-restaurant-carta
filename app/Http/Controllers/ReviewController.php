<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;
use Validator, Auth;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::orderBy('created_at', 'asc')->get();

        if ($reviews) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Reseñas encontradas con éxito', $reviews);

            return response()->json($respuesta, 200);
        } else {
            $respuesta = APIHelpers::createAPIResponse(true, 500, 'No se encontraron reseñas', $reviews);

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
            'email' => 'required',
            'valoracion' => 'required',
            'descripcion' => 'required',
        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'valoracion.required' => 'La valoración es requerido',
            'descripcion.required' => 'La descripción es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);
        }

        $review = new Review();

        $review->name = $request->nombre;
        $review->email = $request->email;
        $review->rating = $request->valoracion;
        $review->description = $request->descripcion;

        if ($review->save()) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Reseña generada con éxito', $review);

            return response()->json($respuesta, 200);
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se pudo generar la reseña ', $validator->errors());

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
     * @param  \App\Models\Review  $review
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $review = Review::where('id', '=', $id)->first();

        if ($review) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Reseña encontrada', $review);
        } else {
            $respuesta = APIHelpers::createAPIResponse(false, 500, 'No se encontró la reseña', 'No se encontró la reseña');
        }

        return $respuesta;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
