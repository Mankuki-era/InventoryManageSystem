<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Information;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use Illuminate\Pagination\Paginator;

class TagsController extends Controller
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
            return TagResource::collection(Tag::where('tag_name', 'like', "%$first_search_content%")->paginate($info->perpage));
        }else{ //Allのとき
            return TagResource::collection(Tag::paginate($info->perpage));
        }
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
}
