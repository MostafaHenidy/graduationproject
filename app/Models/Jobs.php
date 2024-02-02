<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'address',
        'info',
        'cover_image',
        'body',
        'user_id',
    ];
    public function User (){
        return $this->belongsTo('App\Models\User');
    }
}
