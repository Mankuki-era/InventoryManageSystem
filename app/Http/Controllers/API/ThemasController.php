<?php

namespace App\Http\Controllers\API;

use App\Models\Thema;
use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\Notification;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;

class ThemasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $info = Information::find(1);

        $info->currentPage = 1;
        $info->first_search = $request->first_search;
        $info->perpage = $request->perpage;
        $info->currentPage = $request->input('page', 1);
        $info->save();

        // Searchされたとき
        if($request->first_search){
            $first_search_content = $info->first_search;
            return Thema::where('first_category', 'like', "%$first_search_content%")
            ->orWhere('second_category', 'like', "%$first_search_content%")
            ->orWhere('third_category', 'like', "%$first_search_content%")
            ->paginate($info->perpage);
        }else{ //Allのとき
            return Thema::paginate($info->perpage);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grade()
    {
        $gradeList = [];
        $grades = Thema::groupBy('second_category')->get('second_category');
        foreach($grades as $grade){
            array_push($gradeList, $grade->second_category);
        };
        return $gradeList;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function thema(Request $request)
    {
        $themaList = [];
        $themas = Thema::where('second_category', $request->grade)->get('third_category');
        foreach($themas as $thema){
            array_push($themaList, $thema->third_category);
        };
        $grade_belong = Thema::where('second_category', $request->grade)->groupBy('first_category')->get('first_category');

        return response()->json([
            'themaList' => $themaList,
            'grade_belong' => $grade_belong[0]->first_category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $thema = new Thema;

        $thema->first_category = $request->first_category;
        $thema->second_category = $request->second_category;
        $thema->third_category = $request->third_category;

        $thema->save();

        //通知登録
        $notification = new Notification;

        $notification->type = 'ThemaCreate';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = '「' . $request->first_category . ' > ' . $request->second_category . ' > ' . $request->third_category . '」';
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message' => 'テーマの作成が完了しました.',
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
        return Thema::find($id);
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
        $thema = Thema::find($id);
        $before_themaName = '「' . $thema->first_category . ' > ' . $thema->second_category . ' > ' . $thema->third_category . '」';

        $thema->first_category = $request->first_category;
        $thema->second_category = $request->second_category;
        $thema->third_category = $request->third_category;

        $thema->save();

        //通知登録
        $notification = new Notification;

        $notification->type = 'ThemaUpdate';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = $before_themaName;
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message' => 'テーマ情報の更新が完了しました.',
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
        $thema = Thema::find($id);
        $before_themaName = '「' . $thema->first_category . ' > ' . $thema->second_category . ' > ' . $thema->third_category . '」';
        $thema->delete();

        //通知登録
        $notification = new Notification;

        $notification->type = 'ThemaDestroy';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = $before_themaName;
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message' => 'テーマの削除が完了しました.',
        ]);
    }

    public function categoryList() {
        $themas = Thema::all();
        $thema_secondArray = [];
        $thema_thirdArray = [];

        foreach($themas as $thema) {
            if(!in_array($thema->second_category, $thema_secondArray)) {
                array_push($thema_secondArray, $thema->second_category);
            }
        }

        $thema_secondArray = array_unique($thema_secondArray);

        foreach($thema_secondArray as $array) {
            $thema_thirdArray["$array"] = [];
        }

        foreach($themas as $thema) {
            array_push($thema_thirdArray["$thema->second_category"], $thema->third_category);
        }

        return response()->json([
            'thema_secondArray' => $thema_secondArray,
            'thema_thirdArray' => $thema_thirdArray
        ]);
    }
}
