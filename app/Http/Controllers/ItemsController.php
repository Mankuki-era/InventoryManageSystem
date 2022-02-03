<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->tag){
            $items = Item::where('tag', 'like', "%$request->tag%")->get();
        }else{
            $items = Item::all();
        }

        return view('item.index', [
            'items' => $items
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
        return view('item.create');
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
        // dd(unserialize(serialize($request->tag)));

        $item = new Item;

        $item->name = $request->name;
        $item->url = $request->url;
        $item->price = $request->price;
        $item->stocks = $request->stocks;
        $item->tag = isset($request->tag) ? implode(",", $request->tag) : '';

        //画像が選択された場合
        if(isset($request->img_path)){
            // Storageに新しい画像を保存する
            $img_path = Storage::putFile('/public/items', $request->img_path); // /public/items/jk...H82.png
            $img_path = str_replace('public', '/storage', $img_path); // /storage/items/jk...H82.png
            $item->img_path = $img_path;
        }

        $item->save();
        return redirect()->route('main');
        
        
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
        $item = Item::find($id);

        return view('item.show', [
            'item' => $item
        ]);
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
        $item = Item::find($id);

        return view('item.edit', [
            'item' => $item
        ]);
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
        $item = Item::find($id);

        $item->name = $request->name;
        $item->url = $request->url;
        $item->price = $request->price;
        $item->stocks = $request->stocks;
        $item->tag = isset($request->tag) ? implode(",", $request->tag) : '';

        //画像が選択された場合
        if(isset($request->img_path)){
            //画像がno_image.pngではないときはStorageから旧画像を削除する
            if(($item->img_path != '/image/no_image.png')){
                $img_path = str_replace('/storage', '', $item->img_path); // /items/jk...H82.png
                Storage::delete('public' . $img_path);
            }

            // Storageに新しい画像を保存する
            $img_path = Storage::putFile('/public/items', $request->img_path); // /public/items/jk...H82.png
            $img_path = str_replace('public', '/storage', $img_path); // /storage/items/jk...H82.png
            $item->img_path = $img_path;
        }

        $item->save();
        return redirect()->route('main');
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
    }
}
