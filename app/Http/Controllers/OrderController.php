<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //
    public function index()
    {
        //
        $order = Order::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $order
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
        $order = Order::find($id);
        if (empty($order)) {
            return [
                "status" => 0,
                "msg" => "not found order in this id "
            ];
        } else {
            return [
                "status" => 1,
                "data" => [
                    'product' => $order->product,
                    'quantity' => $order->quantity,
                    ]
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
            'quantity' => 'required',
            'product_id' => 'required|int',
        ]);

        if($validator->fails()){
            return $validator->errors()->getMessages();
        }
        if(!$this->checkStock($request)){
            return [
                "status" => 1,
                "msg" => "Can't do this Order on this Time Please try again later",
            ];
        }

        $order = new Order;
        $order->quantity = $request->quantity;
        $order->save();
        $order->product()->attach($request->product_id);
        $this->UpdateStock($order);

        return [
            "status" => 1,
            "msg" => "order stored successfully"
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return array
     */
    public function update(Request $request, Order $order)
    {
        //
        $order->update($request->all());

        return [
            "status" => 1,
            "data" => $order,
            "msg" => "product updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy(Order $order)
    {
        //
        $order->delete();
        return [
            "status" => 1,
            "data" => $order,
            "msg" => "order deleted successfully"
        ];
    }

    public function UpdateStock($order){
        $reminder = [];
        foreach ($order->product as $product)
        foreach ($product->ingredients as $ingredient){
            $stock = Stock::find($ingredient->stock->id);
            $stock->used_capacity += ($ingredient->size_on_g * $order->quantity);
            if(!$stock->reminder) {
                if ($stock->used_capacity > $stock->capacity / 2) {
                    $reminder[] = $stock->name;
                    $stock->reminder = 1;
                }
            }
            $stock->save();
        }
        if(!empty($reminder))
            (new \App\Helpers\MailHelper)->sendToMerchant("a.alhourani@syarah.com" ,$reminder);

    }

    public function checkStock($request , $payload = false){
        if($payload){
            $product_id = $request['product_id'];
            $quantity = $request['quantity'];
        }else{
            $product_id = $request->product_id;
            $quantity = $request->quantity;
        }

        $product = Product::find($product_id);
        if(!empty($product)) {
            $ingredients = $product->ingredients;
            foreach ($ingredients as $ingredient) {
                if (($ingredient->stock->getCapacity() - ($ingredient->size_on_g * $quantity)) < 0) {
                    return 0;
                }
            }
            return 1;
        }
        return 2;
    }

    public function getPayloadOrder(Request $request){
        $counter = 0;
        $orders = $request['products'];
        if(!empty($orders))
        foreach ($orders as $order) {
            $counter++;
            if (!empty($order['product_id']) && !empty($order['quantity'])) {
                $check = $this->checkStock($order , true);
                if ($check == 0) {
                    print  "order $counter Can't do this Order on this Time Please try again later\n";
                    continue;
                }else if($check == 2){
                    print  "order $counter we dont have this product\n";
                    continue;
                }

                $data = new Order;
                $data->quantity = $order['quantity'];
                $data->save();
                $data->product()->attach($order['product_id']);
                $this->UpdateStock($data);

                print  "order $counter  is stored successfully  \n";

            }else {
                print "order $counter should send product id and quantity  \n";
            }
        }
        else
            print "the payload is empty";
    }



}
