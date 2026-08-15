@extends('layouts.app')
@section('title', 'Manage Complaint')

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card card-scp p-4 mb-4">
            <div class="d-flex justify-content-between">
                <h4>{{ $complaint->title }}</h4>
                <span class="badge {{ $complaint->statusBadgeClass() }} align-self-start">{{ ucwords(str_replace('_',' ',$complaint->status)) }}</span>
            </div>
            <p class="text-muted mb-1">Tracking ID: <code>{{ $complaint->complaint_code }}</code></p>
            <p class="mb-1">
                <strong>Submitted by:</strong>
                @if($complaint->is_anonymous)
                    <span class="badge bg-secondary">Anonymous</span>
                @else
                    {{ $complaint->student->name ?? 'Unknown' }} ({{ $complaint->student->roll_number ?? '—' }})
                @endif
            </p>
            <p class="mb-1"><strong>Category:</strong> {{ $complaint->categoryLabel() }} &nbsp;|&nbsp; <strong>Priority:</strong> <span class="text-capitalize">{{ $complaint->priority }}</span></p>
            <p class="mb-1"><strong>Submitted:</strong> {{ $complaint->created_at->format('d M Y, h:i A') }}</p>
            <p class="mb-1"><strong>Assigned to:</strong> {{ $complaint->assignedAdmin->name ?? 'Unassigned' }}</p>
            <hr>
            <p>{{ $complaint->description }}</p>
            @if($complaint->attachment_path)
                <a href="{{ Storage::url($complaint->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-paperclip"></i> View Attachment
                </a>
            @endif
        </div>

        <div class="card card-scp p-4">
            <h5 class="mb-3">Status History</h5>
            <ul class="timeline">
                @foreach($complaint->statusLogs as $log)
                    <li>
                        <span class="badge bg-light text-dark border">{{ ucwords(str_replace('_',' ',$log->status)) }}</span>
                        <div class="small text-muted">{{ $log->created_at->format('d M Y, h:i A') }} — {{ $log->changedByUser->name ?? 'System' }}</div>
                        @if($log->remarks)<div class="small">{{ $log->remarks }}</div>@endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card card-scp p-4 mb-4">
            <h5 class="mb-3">Update Status</h5>
            <form method="POST" action="{{ route('admin.complaints.status', $complaint) }}">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required id="statusSelect">
                        @foreach(['pending'=>'Pending','in_progress'=>'In Progress','resolved'=>'Resolved','rejected'=>'Rejected'] as $val => $label)
                            <option value="{{ $val }}" @selected($complaint->status==$val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Remarks (visible to student)</label>
                    <textarea name="admin_remarks" class="form-control" rows="3">{{ old('admin_remarks', $complaint->admin_remarks) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rejection Reason (only if rejecting)</label>
                    <input type="text" name="rejection_reason" class="form-control" value="{{ old('rejection_reason', $complaint->rejection_reason) }}">
                </div>
                <button class="btn-scp w-100" type="submit">Save Status</button>
            </form>
        </div>

        <div class="card card-scp p-4 mb-4">
            <h5 class="mb-3">Assign Complaint</h5>
            <form method="POST" action="{{ route('admin.complaints.assign', $complaint) }}">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <select name="assigned_to" class="form-select" required>
                        <option value="">-- select admin/officer --</option>
                        @foreach($admins as $a)
                            <option value="{{ $a->id }}" @selected($complaint->assigned_to==$a->id)>{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-outline-secondary w-100" type="submit">Assign</button>
            </form>
        </div>

        <form method="POST" action="{{ route('admin.complaints.destroy', $complaint) }}" onsubmit="return confirm('Delete this complaint permanently?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger w-100" type="submit"><i class="fa-solid fa-trash"></i> Delete Complaint</button>
        </form>
    </div>
</div>
@endsection
