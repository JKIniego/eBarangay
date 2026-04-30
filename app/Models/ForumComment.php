<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    protected $fillable = ['forum_post_id', 'user_id', 'body', 'is_soft_delete', 'deleted_by_admin'];

    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
