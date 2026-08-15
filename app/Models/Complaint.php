<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_code',
        'user_id',
        'is_anonymous',
        'title',
        'category',
        'description',
        'priority',
        'status',
        'attachment_path',
        'assigned_to',
        'admin_remarks',
        'rejection_reason',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'resolved_at' => 'datetime',
        ];
    }

    public static function generateComplaintCode(): string
    {
        // e.g. CMP-2026-4F91A3  — unique, human-shareable tracking ID (FR006)
        do {
            $code = 'CMP-' . now()->format('Y') . '-' . strtoupper(Str::random(6));
        } while (self::where('complaint_code', $code)->exists());

        return $code;
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function statusLogs()
    {
        return $this->hasMany(ComplaintStatusLog::class)->orderBy('created_at');
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'bg-warning text-dark',
            'in_progress' => 'bg-info text-dark',
            'resolved' => 'bg-success',
            'rejected' => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    public function categoryLabel(): string
    {
        return ucwords(str_replace('_', ' ', $this->category));
    }
}
