<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditHistoryForumPost extends Model
{
    protected $fillable = ['forum_post_id', 'body'];

    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class);
    }
}
