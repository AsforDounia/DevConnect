<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'shares',
        'post_type',
        'content_type',
        'content',
        'shares',
        'hashtags'
    ];
    public function user(){
        return $this -> belongsTo(User::class);
    }
    public function comments(){
        return $this -> hasMany(Comment::class);
    }
    public function likes(){
        return $this -> hasMany(Like::class);
    }
    public function tags(){
        return $this -> belongsToMany(Tag::class);
    }
}
