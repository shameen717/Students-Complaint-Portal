@extends('layouts.app')
@section('title', 'Manage Complaints')

@section('content')
<h3 class="mb-3"><i class="fa-solid fa-list-check"></i> Manage Complaints</h3>

<div class="card card-scp p-3 mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small">Search</label>
            <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="ID or title">
        </div>
        <div class="col-md-2">
            <label class="form-label small">Status</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">All</option>
                @foreach(['pending','in_progress','resolved','rejected'] as $s)
                    <option value="{{ $s }}" @selected(request('status')==$s)>{{ ucwords(str_replace('_',' ',$s)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">Category</label>
            <select name="category" class="form-select form-select-sm">
                <option value="">All</option>
                @foreach(['academics','faculty_behavior','hostel','fees','results','harassment','infrastructure','other'] as $c)
                    <option value="{{ $c }}" @selected(request('category')==$c)>{{ ucwords(str_replace('_',' ',$c)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">From</label>
            <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label small">To</label>
            <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
        </div>
        <div class="col-md-1">
            <button class="btn-scp w-100" type="submit">Filter</button>
        </div>
    </form>
</div>

<div class="card card-scp">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>ID</th><th>Title</th><th>Category</th><th>Priority</th><th>Status</th><th>Submitted</th><th></th></tr>
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
                        <td><a href="{{ route('admin.complaints.show', $c) }}" class="btn btn-sm btn-outline-secondary">Manage</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No complaints match these filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $complaints->links() }}</div>
@endsection
