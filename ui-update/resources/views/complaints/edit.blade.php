@extends('layouts.app')
@section('title', 'Edit Complaint')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-scp p-4">
            <h3 class="mb-3">Edit Complaint <code>{{ $complaint->complaint_code }}</code></h3>
            <p class="text-muted">You can only edit this complaint while it is still Pending.</p>
            <form method="POST" action="{{ route('complaints.update', $complaint) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $complaint->title) }}" required maxlength="150">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            @foreach(['academics'=>'Academics','faculty_behavior'=>'Faculty Behavior','hostel'=>'Hostel','fees'=>'Fees','results'=>'Results','harassment'=>'Harassment','infrastructure'=>'Infrastructure','other'=>'Other'] as $val => $label)
                                <option value="{{ $val }}" @selected(old('category', $complaint->category)==$val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select" required>
                            @foreach(['low'=>'Low','medium'=>'Medium','high'=>'High'] as $val => $label)
                                <option value="{{ $val }}" @selected(old('priority', $complaint->priority)==$val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="5" required maxlength="5000">{{ old('description', $complaint->description) }}</textarea>
                </div>
                <button class="btn-scp" type="submit">Update Complaint</button>
                <a href="{{ route('complaints.show', $complaint) }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
