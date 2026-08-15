@extends('layouts.app')
@section('title', 'Track Complaint')

@section('content')
<h1 class="scp-page-header">Track Complaint</h1>

<div class="scp-hero-panel">
    <div class="scp-hero-illustration">
        <div class="icon-wrap">
            <i class="fa-solid fa-magnifying-glass-chart"></i>
        </div>
        <h5>Track Progress</h5>
        <p>Please provide your Complaint Number.</p>
        <a href="{{ route('complaints.create') }}" class="btn-scp-outline mt-3 d-inline-block">Register Complaint</a>
    </div>

    <div class="scp-hero-form">
        <p class="text-muted small mb-1">Enter Application Information Below</p>
        <p class="text-muted small mb-4" style="font-style: italic;">* Required Entry</p>

        <form method="GET" action="{{ route('complaints.track') }}">
            <div class="mb-4">
                <label class="scp-field-label">Complaint Number <span class="req">*</span></label>
                <input type="text" name="code" class="form-control" placeholder="e.g. CMP-2026-4F91A3" value="{{ $code }}" required>
            </div>
            <button class="btn-scp" type="submit">Search Complaint</button>
        </form>
    </div>
</div>

@if($code)
    <hr class="my-4" style="border-color: var(--scp-border);">
    @if($complaint)
        <div class="card card-scp p-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <h5 class="mb-0">{{ $complaint->title }}</h5>
                <span class="badge {{ $complaint->statusBadgeClass() }}">{{ ucwords(str_replace('_',' ',$complaint->status)) }}</span>
            </div>
            <p class="text-muted mb-1 mt-2">Category: {{ $complaint->categoryLabel() }}</p>
            <p class="text-muted mb-3">Submitted: {{ $complaint->created_at->format('d M Y') }}</p>
            <ul class="timeline">
                @foreach($complaint->statusLogs as $log)
                    <li>
                        <span class="badge bg-light text-dark border">{{ ucwords(str_replace('_',' ',$log->status)) }}</span>
                        <div class="small text-muted">{{ $log->created_at->format('d M Y, h:i A') }}</div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="alert alert-warning">No complaint found with tracking ID <strong>{{ $code }}</strong>.</div>
    @endif
@endif
@endsection
