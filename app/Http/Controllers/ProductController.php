<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function index()
    {
        //
        $product = Product::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $product
        ];
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array
     */
    public function show($id)
    {
        //
        $product = Product::find($id);
        if (empty($product)) {
            return [
                "status" => 0,
                "msg" => "not found product in this id "
            ];
        } else {
            return [
                "status" => 1,
                "data" => $product
            ];
        }
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
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'max:255'
        ]);

        if($validator->fails()){
            return $validator->errors()->getMessages();
        }

        $product = Product::create($request->all());
        return [
            "status" => 1,
            "data" => $product
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return array
     */
    public function update(Request $request, Product $product)
    {
        //
        $product->update($request->all());

        return [
            "status" => 1,
            "data" => $product,
            "msg" => "product updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy(product $product)
    {
        //
        $product->delete();
        return [
            "status" => 1,
            "data" => $product,
            "msg" => "product deleted successfully"
        ];
    }

}
