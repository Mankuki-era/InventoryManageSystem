<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::all();

        return view('cart.index', [
            'carts' => $carts
        ]);
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
    public function store(Request $request, $id)
    {
        //
        clock($id);
        clock($request->quantity);
        $cart = new Cart;

        $cart->item_id = $id;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cart = Cart::where('item_id', $id)->delete();

        $carts = Cart::all();
        $count = count($carts);

        $sumprice = 0;
        foreach($carts as $cart){
            $sumprice += $cart->quantity * $cart->item->price;
        }

        return response()->json(['res'=> false, 'count' => $count, 'sumprice' => $sumprice]);
    }

}
