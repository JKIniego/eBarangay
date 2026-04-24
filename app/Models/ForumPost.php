<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    protected $fillable = ['user_id', 'title', 'body', 'is_pinned', 'is_locked'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
