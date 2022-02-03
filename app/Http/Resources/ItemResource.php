<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $bool = isset($this->cart) ? true : false;

        $needs_all = null;
        $needs_pro = null;
        $needs_late = null;

        if($this->require_count){
            $data = unserialize($this->require_count);
            $needs_all = $data['all'];
            $needs_pro = $data['pro'];
            $needs_late = $data['late'];
        }
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'model' => $this->model,
            'first_category' => $this->first_category,
            'second_category' => $this->second_category,
            'third_category' => $this->third_category,
            'comment' => $this->comment,
            'needs_all' => $needs_all,
            'needs_pro' => $needs_pro,
            'needs_late' => $needs_late,
            'img_path' => $this->img_path,
            'price' => $this->price,
            'stocks' => $this->stocks,
            'unit' => $this->unit,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'cart' => $this->cart,
            'tags' => $this->tags,
            'bool' => $bool,
            'favorite' => $this->favorite,
            'btnshow' => false
        ];
    }
}
