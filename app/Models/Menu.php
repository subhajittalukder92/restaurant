<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'restaurant_id',
        'category_id',
        'name',
        'slug',
        'price',
        'description',
        'menu_type',
        'discount_type',
        'discount',
        'status'
    ];
}
