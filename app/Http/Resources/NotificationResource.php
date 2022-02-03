<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Models\Information;
use Carbon\Carbon;

class NotificationResource extends JsonResource
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
            'type' => $this->type,
            'user' => User::find($this->user_id),
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'name' => $this->name,
            'price' => $this->price,
            'count' => $this->count,
            'created_at_Y' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y'),
            'created_at_Date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('m/d'),
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y/m/d H:i:s'),
        ];
    }
}
