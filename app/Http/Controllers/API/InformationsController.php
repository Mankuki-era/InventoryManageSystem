<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Cart;
use App\Models\Tag;
use App\Models\Thema;
use App\Models\History;
use App\Models\Notification;
use App\Models\Information;
use App\Http\Requests\InformationRequest;
use Illuminate\Support\Facades\Storage;

class InformationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    }

    public function countinfo (Request $request){

        $userImage_size = 0;
        $itemImage_size = 0;
        $userImage_category = 'KB';
        $itemImage_category = 'KB';

        if(Storage::files('/public/profiles')){
            foreach(Storage::files('/public/profiles') as $image){
                $userImage_size += Storage::size($image) / 1024;
            }
            if(strlen(floor($userImage_size)) > 4){
                $userImage_size = 0;
                $userImage_category = 'MB';
                foreach(Storage::files('/public/profiles') as $image){
                    $userImage_size += Storage::size($image) / 1048576;
                }
            }
        }
        if(Storage::files('/public/items')){
            foreach(Storage::files('/public/items') as $image){
                $itemImage_size += Storage::size($image) / 1024;
            }
            if(strlen(floor($itemImage_size)) > 4){
                $itemImage_size = 0;
                $itemImage_category = 'MB';
                foreach(Storage::files('/public/profiles') as $image){
                    $itemImage_size += Storage::size($image) / 1048576;
                }
            }
        }


        $user_count = count(User::all());
        $item_count = count(Item::all());
        $cart_count = count(Cart::all());
        $notification_count = count(Notification::all());
        $tag_count = count(Tag::all());
        $thema_count = Thema::all()->count();
        $history_count = History::all()->count();
        return response()->json([
            'user_count' => number_format($user_count),
            'item_count' => number_format($item_count),
            'cart_count' => number_format($cart_count),
            'notification_count' => number_format($notification_count),
            'tag_count' => number_format($tag_count),
            'thema_count' => number_format($thema_count),
            'history_count' => number_format($history_count),
            'userImage_size' => number_format(floor($userImage_size)) . ' ' . $userImage_category,
            'itemImage_size' => number_format(floor($itemImage_size)) . ' ' . $itemImage_category
        ]);
    }

    public function resetinfo (Request $request){
        $info = Information::find(1);
        $info->perpage = 10;
        $info->currentPage = 1;
        $info->first_category = null;
        $info->second_category = null;
        $info->third_category = null;
        $info->first_search = null;
        $info->second_search = null;
        $info->favorite = false;
        if($request->link_name){
            $info->link_name = $request->link_name;
        }
        $info->save();
    }

    public function allResetinfo (Request $request){
        $info = Information::find(1);
        $info->perpage = 10;
        $info->currentPage = 1;
        $info->first_category = null;
        $info->second_category = null;
        $info->third_category = null;
        $info->first_search = null;
        $info->second_search = null;
        $info->favorite = false;
        $info->link_name = 'purchase';
        $info->user_id = null;
        $info->save();
    }

    public function getinfo (Request $request) {
        return Information::find(1);
    }

    public function updateinfo (InformationRequest $request) {
        $info = Information::find(1);

        if(!Hash::check($request->current_password, $info->admin_pass)){
            return response()->json([
                'caution_message'=>'現在のパスワードが異なります.',
            ]);
        }

        $info->admin_pass = Hash::make($request->password);
        $info->save();

        //通知登録
        $notification = new Notification;

        $notification->type = 'PassChange';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = null;
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message'=>'管理者パスワードを変更しました.',
        ]);
    }

    public function checkAdmin(){
        $current_user_id = Information::find(1)->user_id;
        if(User::find($current_user_id)->admin == 'assignment'){
            return response()->json([
                'admin' => true,
            ]);
        }else{
            return response()->json([
                'admin' => false,
            ]);
        }

    }

}
