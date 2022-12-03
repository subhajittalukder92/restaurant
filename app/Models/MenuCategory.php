<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];
    protected $table = 'menu_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'restaurant_id',
        'name',
        'slug',
        'description',
        'status',
    ];
    
    public function media()
    {
        return $this->hasMany(Media::class, 'table_id')->where('table_name', 'menu_categories');
       
    }

    protected static function boot()
    {
        parent::boot();
       
        self::creating(function($model){
        });

        self::updating(function($model){
        });

        self::deleted(function($model){
                  
            foreach ($model->media()->get() as $item) {
                $item->delete();
             
            }
        });
    }
}
