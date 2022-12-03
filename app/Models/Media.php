<?php

namespace App\Models;

use App\Traits\UploaderTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory, UploaderTrait, SoftDeletes;
    protected $guarded = [];
    protected $table = 'medias';


    /**
     * Boot method
    **/
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {

        });

        self::updating(function ($model) {
        });

        self::deleted(function ($model) {
          if (!empty($model->path)) {
            $model->deleteFile($model->path);
          }
        });
    }
}
