<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'images'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function images(){
        return $this->hasMany(Image::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public static function search($title=null){
        $query = self::query();
        if($title){
            $title = strtolower($title);
            $query->whereLike('title',$title);
        }
        return $query;
    }
}
