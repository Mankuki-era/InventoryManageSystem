<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'model',
        'comment',
        'img_path',
        'price',
        'unit',
        'require_count',
        'stocks',
        'first_category',
        'second_category',
        'third_category',
        'favorite',
        // 'tag',
    ];

    public function cart()
    {
        return $this->hasOne('App\Models\Cart', 'item_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    
}
