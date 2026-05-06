<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintReply extends Model
{
    protected $fillable = ['complaint_id', 'user_id', 'message', 'attachment_path'];

    // A reply belongs to one complaint
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    // A reply belongs to the user who wrote it
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
