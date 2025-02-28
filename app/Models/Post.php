<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'content' ,'title' , 'hashtags' ,'image'];


    public function user() {
        return $this->belongsTo(User::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function tags() {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
    public function likes() {
        return $this->belongsToMany(User::class, 'post_user_like');
    }

}
