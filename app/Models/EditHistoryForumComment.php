<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditHistoryForumComment extends Model
{
    protected $fillable = ['forum_comment_id', 'body'];

    public function forumPost()
    {
        return $this->belongsTo(ForumComment::class);
    }
}
