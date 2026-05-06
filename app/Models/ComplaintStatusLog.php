<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintStatusLog extends Model
{
    protected $fillable = ['complaint_id', 'user_id', 'from_status', 'to_status'];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}