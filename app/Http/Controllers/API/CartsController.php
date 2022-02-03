<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CartResource::collection(Cart::all());
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = new Cart;

        $cart->item_id = $request->id;
        $cart->quantity = $request->quantity; //変更

        $cart->save();

        $carts = Cart::all();
        $count = count($carts);

        $sumprice = 0;
        foreach($carts as $cart){
            $sumprice += $cart->quantity * $cart->item->price;
        }

        return response()->json(['res'=> true, 'count' => $count, 'sumprice' => $sumprice]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        if(isset($request->quantity)) {
            $cart->quantity = $request->quantity;
        };
        $cart->remarks = isset($request->remarks) ? $request->remarks : '';
        $cart->save();

        return CartResource::collection(Cart::all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $cart = Cart::where('item_id', $request->id)->delete();

        $carts = Cart::all();
        $count = count($carts);

        $sumprice = 0;
        foreach($carts as $cart){
            $sumprice += $cart->quantity * $cart->item->price;
        }

        return response()->json(['res'=> false, 'count' => $count, 'sumprice' => $sumprice]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::find($id);
        $cart->delete();

        return CartResource::collection(Cart::all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function cartinfo()
    {
        $carts = Cart::all();
        $count = count($carts);

        $sumprice = 0;
        foreach($carts as $cart){
            $sumprice += $cart->quantity * $cart->item->price;
        }

        return response()->json(['count'=> $count, 'sumprice' => $sumprice]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request) {
        DB::table('carts')->truncate();
    }

}
