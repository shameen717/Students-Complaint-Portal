<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintStatusLog extends Model
{
    protected $fillable = ['complaint_id', 'status', 'remarks', 'changed_by'];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function changedByUser()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
