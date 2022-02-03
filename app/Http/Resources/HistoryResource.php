<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class HistoryResource extends JsonResource
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
            'table_content' => unserialize($this->table_content),
            'user_name' => $this->user_name,
            'create_Y' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y'),
            'create_D' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('m/d'),
            'create_T' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('H:i'),
        ];
    }
}
