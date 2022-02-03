<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Tag;
use App\Models\Thema;
use App\Models\Information;
use App\Models\Notification;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ItemsImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if($row[0] == null && $row[1] == null && $row[2] == null && $row[3] == null && $row[4] == null && $row[5] == null && $row[6] == null && $row[7] == null && $row[8] == null && $row[9] == null && $row[10] == null && $row[11] == null && $row[12] == null && $row[13] == null && $row[14] == null && $row[15] == null) {
                break;
            }
            $item = new Item;

            $item->name = $row[0];
            $item->model = $row[1] != null ? $row[1] : null;
            $item->price = $row[2] != null ? $row[2] : 0;
            $item->stocks = preg_replace('/[^0-9]/', '', $row[3]);
            $item->unit = str_replace($item->stocks, '', $row[3]);
            $item->url = $row[4] != null ? $row[4] : null;
            $array = [
                'all' => $row[7],
                'pro' => $row[5],
                'late' => $row[6],
            ];
            $item->require_count = serialize($array);
            $thema = Thema::where('second_category', $row[8])->first();
            $item->first_category = $thema->first_category;
            $item->second_category = $row[8];
            $item->third_category = $row[9];
            $item->comment = $row[10] != null ? $row[10] : null;

            $fixTags = [];
            if($item->first_category != null){
                array_push($fixTags, $item->first_category);
            }
            if($row[8] != null){
                array_push($fixTags, $row[8]);
            }
            if($row[9] != null){
                array_push($fixTags, $row[9]);
            }
            if($row[11] != null){
                array_push($fixTags, $row[11]);
            }
            if($row[12] != null){
                array_push($fixTags, $row[12]);
            }
            if($row[13] != null){
                array_push($fixTags, $row[13]);
            }
            if($row[14] != null){
                array_push($fixTags, $row[14]);
            }
            if($row[15] != null){
                array_push($fixTags, $row[15]);
            }

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

        //通知登録
        $notification = new Notification;

        $notification->type = 'ItemImport';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = null;
        $notification->price = null;
        $notification->count = null;

        $notification->save();
    }
}
