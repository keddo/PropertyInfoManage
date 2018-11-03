<?php

namespace App\Http\Controllers\API;

use App\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    /**
     * Create a new controller instance.
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
        return Material::oldest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|string|max:50',
            'code' => 'required|string|max:20',
            'unit_measure' => 'required|string|max:10',
            'quantity' => 'required',
            'unit_price' => 'required',
        ]);

        return Material::create([
            'description' => $request['description'],
            'code' => $request['code'],
            'unit_measure' => $request['unit_measure'],
            'quantity' => $request['quantity'],
            'unit_price' => $request['unit_price'],
            'total_value' => $request['unit_price']  * $request['quantity'] ,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $editItem = Material::findOrFail($material->id);
        $this->validate($request, [
            'description' => 'required|string|max:50',
            'code' => 'required|string|max:20',
            'unit_measure' => 'required|string|max:10',
            'quantity' => 'required',
            'unit_price' => 'required',
        ]);
       $request['total_value'] = $request['unit_price'] + $request['quantity'];

       $editItem->update($request->all());

       return ['message' => 'Update Successfull'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        //
    }
}
