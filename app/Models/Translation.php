<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable=[
        'lang',
        'lang_key',
        'lang_value',
      ];

    public function scopeFiltr($val, $model){
    $model->where('lang', $val)->get();
    return $model;
    }

    // public function Language(){
    //   return $this->belongsTo(language::class);
    // }
}
