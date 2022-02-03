<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Tag;
use App\Models\Information;
use App\Models\Notification;
use Illuminate\Pagination\Paginator;
use App\Http\Resources\ItemResource;
use App\Http\Requests\ItemRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $info = Information::find(1);

        if($request->input('page', 1)) $info->currentPage = $request->input('page', 1);
        if($request->favorite) {
            if($request->favorite == 'true'){
                $info->favorite = true;
            }else{
                $info->favorite = false;
            }
        }
        $info->first_category = $request->first_category;
        $info->second_category = $request->second_category;
        $info->third_category = $request->third_category;
        $info->first_search = $request->first_search;
        $info->second_search = $request->second_search;
        $info->perpage = $request->perpage;

        $info->save();

        //AsideLinkかTagがクリックされたとき, または初期状態
        if($info->first_search){
            $first_search_content = $info->first_search;
            if($info->second_search){
                return ItemResource::collection(Item::whereHas('tags', function($query) use($first_search_content){
                    $query->where('tag_name', $first_search_content);
                })->where('name', 'like', "%$info->second_search%")->paginate($info->perpage));
            }else{
                return ItemResource::collection(Item::whereHas('tags', function($query) use($first_search_content){
                    $query->where('tag_name', $first_search_content);
                })->paginate($info->perpage));
            }

        }else{ //Allのとき, または初期状態
            if($info->favorite) {
                if($info->second_search){
                    return ItemResource::collection(Item::where('favorite', true)->where('name', 'like', "%$info->second_search%")->paginate($info->perpage));
                }else{
                    return ItemResource::collection(Item::where('favorite', true)->paginate($info->perpage));
                }
            }else{
                if($info->second_search){
                    return ItemResource::collection(Item::where('name', 'like', "%$info->second_search%")->paginate($info->perpage));
                }else{
                    return ItemResource::collection(Item::paginate($info->perpage));
                }
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $item = new Item;

        $item->name = $request->name;
        $item->url = isset($request->url) ? $request->url : null;
        $item->price = $request->price;
        $item->stocks = $request->stocks;
        $item->unit = isset($request->unit) ? $request->unit : "";
        $item->model = isset($request->model) ? $request->model : null;
        $item->first_category = $request->first_category;
        $item->second_category = $request->second_category;
        $item->third_category = $request->third_category;
        $item->comment = isset($request->comment) ? $request->comment : null;
        if(isset($request->needsAll) || isset($request->needsPro) || isset($request->needsLate)) {
            $array = [
                'all' => $request->needsAll,
                'pro' => $request->needsPro,
                'late' => $request->needsLate,
            ];
            $item->require_count = serialize($array);
        }

        //画像が選択された場合
        if(isset($request->file)){
            // Storageに新しい画像を保存する
            $img_path = Storage::putFile('/public/items', $request->file); // /public/items/jk...H82.png
            $img_path = str_replace('public', '/storage', $img_path); // /storage/items/jk...H82.png
            $item->img_path = $img_path;
        }

        //$request->tagsは配列ではなくカンマ区切りのタグなので配列に変換する.
        $fixTags = explode(",", $request->tags);

        //タグをタグテーブルと中間テーブルに保存
        $tags = [];
        foreach($fixTags as $tag){
            $found = Tag::firstOrCreate(['tag_name' => $tag]);
            array_push($tags, $found);
        }

        $tag_ids = [];
        foreach($tags as $tag){
            array_push($tag_ids, $tag['id']);
        }

        $item->save();
        $item->tags()->attach($tag_ids);

        //通知登録
        $notification = new Notification;

        $notification->type = 'ItemCreate';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = $item->name;
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message'=>'製品登録が完了しました.',
        ]);
    }

    //管理者のための一括挿入機能
    public function admincreate(Request $request) {

        for($i = 0; $i < $request->count; $i++){
            $item = new Item;
    
            $item->name = $request["name_{$i}"];
            $item->url = $request["url_{$i}"];
            $item->price = $request["price_{$i}"];
            $item->stocks = $request["stocks_{$i}"];
            $item->model = $request["model_{$i}"];
            $item->first_category = $request["first_category_{$i}"];
            $item->second_category = $request["second_category_{$i}"];
            $item->third_category = $request["third_category_{$i}"];
            $item->comment = isset($request["comment_{$i}"]) ? $request["comment_{$i}"] : null;
    
            //画像が選択された場合
            if(isset($request["file_{$i}"])){
                // Storageに新しい画像を保存する
                $img_path = Storage::putFile('/public/items', $request["file_{$i}"]); // /public/items/jk...H82.png
                $img_path = str_replace('public', '/storage', $img_path); // /storage/items/jk...H82.png
                $item->img_path = $img_path;
            }

            //$request->tagsは配列ではなくカンマ区切りのタグなので配列に変換する.
            $fixTags = explode(",", $request["tags_{$i}"]);
    
            //タグをタグテーブルと中間テーブルに保存
            $tags = [];
            foreach($fixTags as $tag){
                $found = Tag::firstOrCreate(['tag_name' => $tag]);
                array_push($tags, $found);
            }
    
            $tag_ids = [];
            foreach($tags as $tag){
                array_push($tag_ids, $tag['id']);
            }
    
            $item->save();
            $item->tags()->attach($tag_ids);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ItemResource(Item::find($id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function stocksUpdate(Request $request, $id)
    {
        $item = Item::find($id);

        if($request->bool == 'true'){
            $item->stocks += $request->stocks;
        }else{
            $item->stocks -= $request->stocks;
        }
        $item->save();

        //通知登録
        $notification = new Notification;

        if($request->bool === 'true'){
            $notification->type = 'ItemSupply';
        }else{
            $notification->type = 'ItemConsume';
        }
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = $request->item_name;
        $notification->price = null;
        $notification->count = $request->stocks;

        $notification->save();

        if($request->bool == 'true'){
            return response()->json([
                'message'=>'製品の納入数を登録しました.',
            ]);
        }else {
            return response()->json([
                'message'=>'製品の消費数を登録しました.',
            ]);
        }
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
        $item = Item::find($id);

        //旧タグ
        $beforetag_ids = [];
        foreach($item->tags as $tag){
            array_push($beforetag_ids, $tag->id);
        }

        $item->name = $request->name;
        $item->url = isset($request->url) ? $request->url : null;
        $item->price = isset($request->price) ? $request->price : 0;
        $item->stocks = $request->stocks;
        $item->unit = isset($request->unit) ? $request->unit : "";
        $item->model = isset($request->model) ? $request->model : null;
        $item->first_category = $request->first_category;
        $item->second_category = $request->second_category;
        $item->third_category = $request->third_category;
        $item->comment = isset($request->comment) ? $request->comment : null;
        if(isset($request->needsAll) || isset($request->needsPro) || isset($request->needsLate)) {
            $array = [
                'all' => $request->needsAll,
                'pro' => $request->needsPro,
                'late' => $request->needsLate,
            ];
            $item->require_count = serialize($array);
        }

        //画像が選択された場合(つまり変更される場合)
        if(isset($request->file)){
            //Storageから旧画像を削除する
            $img_path = str_replace('/storage', '', $item->img_path); // /items/jk...H82.png
            Storage::delete('public' . $img_path);
            // Storageに新しい画像を保存する
            $img_path = Storage::putFile('/public/items', $request->file); // /public/items/jk...H82.png
            $img_path = str_replace('public', '/storage', $img_path); // /storage/items/jk...H82.png
            $item->img_path = $img_path;
        }

        //新タグ($request->tagsは配列ではなくカンマ区切りのタグなので配列に変換する.)
        $fixTags = explode(",", $request->tags);

        $tags = [];
        foreach($fixTags as $tag){
            $found = Tag::firstOrCreate(['tag_name' => $tag]);
            array_push($tags, $found);
        }

        $tag_ids = [];
        foreach($tags as $tag){
            array_push($tag_ids, $tag['id']);
        }

        $delete_ids = array_diff($beforetag_ids, $tag_ids);
        $delete_ids_fix = [];
        foreach($delete_ids as $id){
            if(count(Tag::find($id)->items) === 1){
                array_push($delete_ids_fix, $id);
            }
        }

        $item->save();
        $item->tags()->sync($tag_ids); //中間テーブルを更新
        
        Tag::destroy($delete_ids_fix);

        //通知登録
        $notification = new Notification;

        $notification->type = 'ItemUpdate';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = $item->name;
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message'=>'製品情報の更新が完了しました.',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        if($item->img_path !== '/image/no_image.png'){
            //Storageから旧画像を削除する
            $img_path = str_replace('/storage', '', $item->img_path); // /items/jk...H82.png
            Storage::delete('public' . $img_path);
        }
        $tag_ids = [];
        foreach($item->tags as $tag){
            array_push($tag_ids, $tag->id);
        }
        
        $delete_ids = [];
        foreach($tag_ids as $id){
            if(count(Tag::find($id)->items) === 1){
                array_push($delete_ids, $id);
            }
        }

        $item->tags()->detach($tag_ids);
        Tag::destroy($delete_ids);
        $item->delete();

        //通知登録
        $notification = new Notification;

        $notification->type = 'ItemDestroy';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = $item->name;
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message'=>'製品の削除が完了しました.',
        ]);
    }

    public function refresh(Request $request) {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('carts')->truncate();
        DB::table('item_tag')->truncate();
        DB::table('items')->truncate();
        DB::table('tags')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $file = new Filesystem;
        $file->cleanDirectory( storage_path() . '/app/public/items');

        //通知登録
        $notification = new Notification;

        $notification->type = 'RefreshTable';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = '製品';
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message'=>'テーブルをリフレッシュしました.',
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function favorite(Request $request)
    {
        $item = Item::find($request->id);
        $item->favorite = true;
        $item->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function unfavorite(Request $request)
    {
        $item = Item::find($request->id);
        $item->favorite = false;
        $item->save();
    }
}
