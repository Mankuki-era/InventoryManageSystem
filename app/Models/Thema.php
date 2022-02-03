<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thema extends Model
{
    use HasFactory;

    protected $table = 'themas';

    protected $fillable = [
        'first_category',
        'second_category',
        'third_category',
    ];

}
