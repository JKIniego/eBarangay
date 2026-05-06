<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference_no',
        'subject',
        'description',
        'category',
        'status',
        'priority',
        'attachment_path',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function replies()
    {
        // oldest first so the chat thread reads top-to-bottom chronologically
        return $this->hasMany(ComplaintReply::class)->with('user')->oldest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(ComplaintStatusLog::class)->with('user')->latest();
    }
}