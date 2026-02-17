<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'linkVideo',
        'imagePost',
        'views_count',
        'uploadArquivo',
    ];

    public function user(){
        return$this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public static function search($search){
        return self::where('title', "like", "%{$search}%")
            ->orwhere('content', "like", "%{$search}%")
            ->with(['user', 'comments'])
            ->paginate(4);
    }
}
