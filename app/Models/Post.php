<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
        // return $this->hasMany(Comment::class);
    }

    public function usersWhoLiked() {
        return $this->belongsToMany(User::class, 'likes')->withTimeStamps();
    }

}
