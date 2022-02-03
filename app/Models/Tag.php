<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_name'
    ];

    public function items()
    {
        return $this->belongsToMany('App\Models\Item');
    }
}
