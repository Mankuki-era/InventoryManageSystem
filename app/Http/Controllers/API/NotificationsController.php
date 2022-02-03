<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\Notification;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NotificationResource::collection(Notification::orderBy('created_at', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notification = new Notification;

        $notification->type = $request->type;
        $notification->user_id = $request->user_id;
        $notification->item_id = $request->item_id;
        $notification->price = isset($request->price) ? $request->price : null;
        $notification->count = isset($request->count) ? $request->count : null;

        $notification->save();

        return response()->json([
            'message'=>'通知に登録しました.',
        ]);
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

    public function refresh(Request $request) {
        DB::table('notifications')->truncate();

        //通知登録
        $notification = new Notification;

        $notification->type = 'RefreshTable';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = '通知';
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message'=>'テーブルをリフレッシュしました.',
        ]);
    }
}
