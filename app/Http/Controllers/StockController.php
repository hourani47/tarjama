<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        //
        $stocks = Stock::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $stocks
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->json()->all(), [
            'name' => 'required',
            'capacity' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->getMessages();
        }

        $stock = new Stock();
        $stock->name = $request->name;
        $stock->capacity = $request->capacity * 1000;
        $stock->save();
        return [
            "status" => 1,
            "data" => $stock
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        //
        $stock =  Stock::find($id);
        if(empty($stock)){
            return [
                "status" => 0,
                "msg" => "not found stock in this id "
            ];
        }else {
            return [
                "status" => 1,
                "data" => $stock
            ];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array
     */
    public function update(Request $request, Stock $stock)
    {
        //
        $stock->capacity = $stock->capacity - $stock->used_capacity +  ($request->capacity * 1000);
        $stock->used_capacity = 0;
        $stock->save();

        if($stock->reminder == 1) {
            $stock->reminder = 0;
            $stock->save();
        }

        return [
            "status" => 1,
            "data" => $stock,
            "msg" => "stock updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy(Stock $stock)
    {
        //
        $stock->delete();
        return [
            "status" => 1,
            "data" => $stock,
            "msg" => "stock deleted successfully"
        ];
    }
}
