@extends('layouts.app')
@section('title', 'Complaint '.$complaint->complaint_code)

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card card-scp p-4 mb-4">
            <div class="d-flex justify-content-between">
                <h4>{{ $complaint->title }}</h4>
                <span class="badge {{ $complaint->statusBadgeClass() }} align-self-start">{{ ucwords(str_replace('_',' ',$complaint->status)) }}</span>
            </div>
            <p class="text-muted mb-1">Tracking ID: <code>{{ $complaint->complaint_code }}</code></p>
            <p class="mb-1"><strong>Category:</strong> {{ $complaint->categoryLabel() }} &nbsp; | &nbsp; <strong>Priority:</strong> <span class="text-capitalize">{{ $complaint->priority }}</span></p>
            <p class="mb-1"><strong>Submitted:</strong> {{ $complaint->created_at->format('d M Y, h:i A') }}</p>
            @if($complaint->is_anonymous)
                <p class="mb-1"><span class="badge bg-secondary">Submitted Anonymously</span></p>
            @endif
            <hr>
            <p>{{ $complaint->description }}</p>
            @if($complaint->attachment_path)
                <a href="{{ Storage::url($complaint->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-paperclip"></i> View Attachment
                </a>
            @endif

            @if($complaint->admin_remarks)
                <div class="alert alert-info mt-3 mb-0">
                    <strong>Admin remarks:</strong> {{ $complaint->admin_remarks }}
                </div>
            @endif
            @if($complaint->status === 'rejected' && $complaint->rejection_reason)
                <div class="alert alert-danger mt-3 mb-0">
                    <strong>Rejection reason:</strong> {{ $complaint->rejection_reason }}
                </div>
            @endif

            @if(!$complaint->is_anonymous && $complaint->status === 'pending' && $complaint->user_id === auth()->id())
                <a href="{{ route('complaints.edit', $complaint) }}" class="btn btn-outline-secondary btn-sm mt-3">Edit Complaint</a>
            @endif
        </div>
    </div>

    <div class="col-md-5">
        <div class="card card-scp p-4">
            <h5 class="mb-3"><i class="fa-solid fa-timeline"></i> Status History</h5>
            <ul class="timeline">
                @foreach($complaint->statusLogs as $log)
                    <li>
                        <span class="badge {{ \App\Models\Complaint::class ? '' : '' }} bg-light text-dark border">{{ ucwords(str_replace('_',' ',$log->status)) }}</span>
                        <div class="small text-muted">{{ $log->created_at->format('d M Y, h:i A') }}</div>
                        @if($log->remarks)
                            <div class="small">{{ $log->remarks }}</div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
