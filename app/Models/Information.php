<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $table = 'informations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'perpage',
        'currentPage',
        'first_category',
        'second_category',
        'third_category',
        'first_search',
        'second_search',
        'user_id',
        'admin_pass',
        'link_name',
        'favorite'
    ];
}
