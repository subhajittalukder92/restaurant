<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'order_items';

    public function menu(){
        return $this->belongsTo('App\Models\Menu', 'menu_id', 'id');
    }
}
