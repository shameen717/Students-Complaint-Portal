@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

{{-- Admin Header Banner --}}
<div class="admin-header-bar">
    <img src="{{ asset('images/iub-logo.png') }}"
         onerror="this.style.display='none'"
         alt="IUB" class="admin-header-logo">
    <div class="admin-header-text">
        <h2><i class="fa-solid fa-gauge me-2"></i>Admin Dashboard</h2>
        <p>Welcome back, {{ auth()->user()->name }} &mdash; here's today's overview</p>
        <span class="admin-gold-badge"><i class="fa-solid fa-shield-halved me-1"></i>Administrator</span>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md">
        <div class="stat-card bg-scp-purple">
            <i class="fa-solid fa-layer-group stat-icon"></i>
            <small>Total</small>
            <h3>{{ $totals['total'] }}</h3>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="stat-card bg-scp-pending">
            <i class="fa-solid fa-clock stat-icon"></i>
            <small>Pending</small>
            <h3>{{ $totals['pending'] }}</h3>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="stat-card bg-scp-progress">
            <i class="fa-solid fa-spinner stat-icon"></i>
            <small>In Progress</small>
            <h3>{{ $totals['in_progress'] }}</h3>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="stat-card bg-scp-resolved">
            <i class="fa-solid fa-circle-check stat-icon"></i>
            <small>Resolved</small>
            <h3>{{ $totals['resolved'] }}</h3>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="stat-card bg-scp-rejected">
            <i class="fa-solid fa-circle-xmark stat-icon"></i>
            <small>Rejected</small>
            <h3>{{ $totals['rejected'] }}</h3>
        </div>
    </div>
</div>

{{-- Second Row: Category breakdown + Avg resolution --}}
<div class="row g-3 mb-4">
    <div class="col-md-7">
        <div class="card card-scp h-100">
            <div class="card-scp-header">
                <i class="fa-solid fa-chart-pie"></i> Complaints by Category
            </div>
            <div class="p-3">
                <table class="table table-hover table-sm mb-0 align-middle">
                    <thead class="table-light">
                        <tr class="table-navy-head">
                            <th>Category</th>
                            <th class="text-end">Count</th>
                            <th class="text-end">Share</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($byCategory as $row)
                        @php $pct = $totals['total'] > 0 ? round(($row->total / $totals['total']) * 100) : 0; @endphp
                        <tr>
                            <td>{{ ucwords(str_replace('_',' ',$row->category)) }}</td>
                            <td class="text-end fw-bold">{{ $row->total }}</td>
                            <td class="text-end" style="width:140px;">
                                <div class="d-flex align-items-center gap-2 justify-content-end">
                                    <div style="width:80px;height:6px;background:#e0e7ef;border-radius:99px;overflow:hidden;">
                                        <div style="width:{{ $pct }}%;height:100%;background:var(--iub-navy);border-radius:99px;"></div>
                                    </div>
                                    <span class="text-muted" style="font-size:.78rem;">{{ $pct }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-muted py-3 text-center">No data yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card card-scp h-100">
            <div class="card-scp-header">
                <i class="fa-solid fa-stopwatch"></i> Resolution Stats
            </div>
            <div class="p-4 d-flex flex-column justify-content-center h-100">
                <p class="text-muted small mb-1 text-uppercase fw-bold" style="letter-spacing:.07em;font-size:.72rem;">Average Resolution Time</p>
                <p class="display-5 fw-900 mb-0" style="color:var(--iub-navy);font-weight:900;">
                    {{ $avgResolutionHours ? round($avgResolutionHours, 1) : '—' }}
                    <span style="font-size:1.2rem;font-weight:600;color:var(--iub-muted);">hrs</span>
                </p>
                <p class="text-muted small mt-1 mb-3">Based on all resolved complaints</p>
                <hr>
                <div class="d-flex justify-content-between mt-2">
                    <div class="text-center">
                        <p class="mb-0 fw-bold" style="color:var(--iub-navy);font-size:1.3rem;">{{ $totals['resolved'] }}</p>
                        <small class="text-muted">Resolved</small>
                    </div>
                    <div class="text-center">
                        <p class="mb-0 fw-bold" style="color:#f39c12;font-size:1.3rem;">{{ $totals['pending'] }}</p>
                        <small class="text-muted">Pending</small>
                    </div>
                    <div class="text-center">
                        <p class="mb-0 fw-bold" style="color:#c0392b;font-size:1.3rem;">{{ $totals['rejected'] }}</p>
                        <small class="text-muted">Rejected</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Complaints Table --}}
<div class="card card-scp">
    <div class="card-scp-header d-flex justify-content-between align-items-center">
        <span><i class="fa-solid fa-clock-rotate-left"></i> Recent Complaints</span>
        <a href="{{ route('admin.complaints.index') }}"
           style="background:var(--iub-gold);color:var(--iub-navy);border-radius:999px;padding:.3rem 1rem;font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.05em;text-decoration:none;">
            View All <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr class="table-navy-head">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentComplaints as $c)
                <tr>
                    <td><code style="background:var(--iub-sky);color:var(--iub-navy);padding:.2rem .5rem;border-radius:5px;font-size:.8rem;">{{ $c->complaint_code }}</code></td>
                    <td style="max-width:200px;" class="text-truncate">{{ $c->title }}</td>
                    <td>{{ $c->categoryLabel() }}</td>
                    <td><span class="badge {{ $c->statusBadgeClass() }}">{{ ucwords(str_replace('_',' ',$c->status)) }}</span></td>
                    <td class="text-muted" style="font-size:.85rem;">{{ $c->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.complaints.show', $c) }}"
                           style="background:var(--iub-navy);color:var(--white);border-radius:999px;padding:.3rem .9rem;font-size:.75rem;font-weight:700;text-decoration:none;white-space:nowrap;">
                           Manage
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
