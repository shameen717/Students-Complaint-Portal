@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<h3 class="mb-4"><i class="fa-solid fa-gauge"></i> Admin Dashboard</h3>

<div class="row g-3 mb-4">
    <div class="col-md-2-4 col-6 col-md">
        <div class="stat-card bg-scp-purple"><small>Total</small><h3>{{ $totals['total'] }}</h3></div>
    </div>
    <div class="col-6 col-md">
        <div class="stat-card bg-scp-pending"><small>Pending</small><h3>{{ $totals['pending'] }}</h3></div>
    </div>
    <div class="col-6 col-md">
        <div class="stat-card bg-scp-progress"><small>In Progress</small><h3>{{ $totals['in_progress'] }}</h3></div>
    </div>
    <div class="col-6 col-md">
        <div class="stat-card bg-scp-resolved"><small>Resolved</small><h3>{{ $totals['resolved'] }}</h3></div>
    </div>
    <div class="col-6 col-md">
        <div class="stat-card bg-scp-rejected"><small>Rejected</small><h3>{{ $totals['rejected'] }}</h3></div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card card-scp p-4 h-100">
            <h5>Complaints by Category</h5>
            <table class="table table-sm mb-0">
                <tbody>
                @forelse($byCategory as $row)
                    <tr>
                        <td>{{ ucwords(str_replace('_',' ',$row->category)) }}</td>
                        <td class="text-end fw-bold">{{ $row->total }}</td>
                    </tr>
                @empty
                    <tr><td class="text-muted">No data yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-scp p-4 h-100">
            <h5>Average Resolution Time</h5>
            <p class="display-6 mb-0">{{ $avgResolutionHours ? round($avgResolutionHours, 1) : '—' }} hrs</p>
            <p class="text-muted small mb-0">Based on all resolved complaints.</p>
        </div>
    </div>
</div>

<div class="card card-scp p-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Recent Complaints</h5>
        <a href="{{ route('admin.complaints.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>ID</th><th>Title</th><th>Category</th><th>Status</th><th>Submitted</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($recentComplaints as $c)
                    <tr>
                        <td><code>{{ $c->complaint_code }}</code></td>
                        <td>{{ $c->title }}</td>
                        <td>{{ $c->categoryLabel() }}</td>
                        <td><span class="badge {{ $c->statusBadgeClass() }}">{{ ucwords(str_replace('_',' ',$c->status)) }}</span></td>
                        <td>{{ $c->created_at->format('d M Y') }}</td>
                        <td><a href="{{ route('admin.complaints.show', $c) }}" class="btn btn-sm btn-outline-secondary">Manage</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
