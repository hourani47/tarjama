<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngredientController extends Controller
{
    //
    public function index()
    {
        $ingredient = Ingredient::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $ingredient
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
        $ingredient =  Ingredient::find($id);
        if(empty($ingredient)){
            return [
                "status" => 0,
                "msg" => "not found ingredient in this id "
            ];
        }else {
            return [
                "status" => 1,
                "data" => $ingredient
            ];
        }
    }

    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->json()->all(), [
            'name' => 'required',
            'size_on_g' => 'required|int',
            'stock_id' => 'required|int',
            'product_id' => 'required|int'
        ]);

        if ($validator->fails()) {
            return $validator->errors()->getMessages();
        }

        $ingredient = Ingredient::create($request->all());
        return [
            "status" => 1,
            "data" => $ingredient
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        //
        $ingredient->update($request->all());

        return [
            "status" => 1,
            "data" => $ingredient,
            "msg" => "ingredient updated successfully"
        ];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy(Ingredient $ingredient)
    {
        //
        $ingredient->delete();
        return [
            "status" => 1,
            "data" => $ingredient,
            "msg" => "ingredient deleted successfully"
        ];
    }
}
