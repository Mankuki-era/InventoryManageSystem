<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\History;
use App\Models\Notification;
use App\Models\Information;
use App\Exports\Export;
use App\Exports\CartsExportView;
use App\Exports\ItemsExportView;
use Illuminate\Support\Facades\DB;
use Excel;

class ExportExcelController extends Controller
{
    function index()
    {
        $carts = Cart::all();
        $notifications = Notification::all();

        return view('carts.confirm')->with([
            "carts" => $carts,
            "notifications" => $notifications,
        ]);
    }

    function export_page()
    {
        $carts = Cart::all();
        $notifications = Notification::all();

        return view('items.export');
    }

    public function export_view()
    {
        $carts = Cart::all();
        $sumprice = 0;

        $history_array = [];
        foreach($carts as $cart) {
            $sumprice += $cart->item->price * $cart->quantity;
            array_push($history_array, [
                'name' => $cart->item->name,
                'model' => $cart->item->model == null ? '' : $cart->item->model,
                'remarks' => $cart->remarks == null ? '' : $cart->remarks,
                'price' => $cart->item->price,
                'quantity' => $cart->quantity,
                'sumprice' => $cart->item->price * $cart->quantity,
                'url' => $cart->item->url == null ? '' : $cart->item->url,
            ]);
        }

        //通知登録
        $notification = new Notification;

        $notification->type = 'ItemPurchase';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = null;
        $notification->price = $sumprice;
        $notification->count = count(Cart::all());

        $notification->save();

        $history = new History;
        $history->table_content = serialize($history_array);
        $history->user_name = User::find(Information::find(1)->user_id)->name;
        $history->save();

        $name = '発注表_';
        $time = \Carbon\Carbon::today()->format("Y-m-d");
        return Excel::download(new CartsExportView(), $name . $time . '.xlsx');
    }

    public function items_export_view()
    {
        //通知登録
        $notification = new Notification;

        $notification->type = 'ItemBackup';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = null;
        $notification->price = null;
        $notification->count = null;

        $notification->save();
        $name = 'backup_';
        $time = \Carbon\Carbon::today()->format("Y-m-d");
        return Excel::download(new ItemsExportView(), $name . $time . '.xlsx');
    }

}

