<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        return [
            'id' => $this->id,
            'remarks' => $this->remarks,
            'item_id' => $this->item->id,
            'name' => $this->item->name,
            'url' => $this->item->url,
            'model' => $this->item->model,
            'first_category' => $this->item->first_category,
            'second_category' => $this->item->second_category,
            'third_category' => $this->item->third_category,
            'comment' => $this->item->comment,
            'img_path' => $this->item->img_path,
            'price' => $this->item->price,
            'stocks' => $this->item->stocks,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'quantity' => $this->quantity,
            'tags' => $this->item->tags,
        ];
    }
}
