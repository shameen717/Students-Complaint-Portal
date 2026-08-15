@extends('layouts.app')
@section('title', 'My Complaints')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><i class="fa-solid fa-list-check"></i> My Complaints</h3>
    <a href="{{ route('complaints.create') }}" class="btn-scp">+ New Complaint</a>
</div>

<div class="card card-scp">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tracking ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints as $c)
                    <tr>
                        <td><code>{{ $c->complaint_code }}</code></td>
                        <td>{{ $c->title }}</td>
                        <td>{{ $c->categoryLabel() }}</td>
                        <td class="text-capitalize">{{ $c->priority }}</td>
                        <td><span class="badge {{ $c->statusBadgeClass() }}">{{ ucwords(str_replace('_',' ',$c->status)) }}</span></td>
                        <td>{{ $c->created_at->format('d M Y') }}</td>
                        <td><a href="{{ route('complaints.show', $c) }}" class="btn btn-sm btn-outline-secondary">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">You haven't submitted any complaints yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $complaints->links() }}</div>
@endsection
