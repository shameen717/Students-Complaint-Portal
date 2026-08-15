@extends('layouts.app')
@section('title', 'Register Complaint')

@section('content')
<h1 class="scp-page-header">Register Complaint</h1>

<div class="scp-hero-panel">
    <div class="scp-hero-illustration">
        <div class="icon-wrap">
            <i class="fa-solid fa-file-circle-plus"></i>
            <span class="icon-badge"><i class="fa-solid fa-question"></i></span>
        </div>
        <h5>New Complaint</h5>
        <p>Please fill in the details below to start your complaint.</p>
        <a href="{{ route('complaints.track') }}" class="btn-scp-outline mt-3 d-inline-block">Track Progress</a>
    </div>

    <div class="scp-hero-form">
        <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="scp-field-label">Complaint Category <span class="req">*</span></label>
                <select name="category" class="form-select" required>
                    <option value="">-- Select Complaint Category --</option>
                    @foreach(['academics'=>'Academics','faculty_behavior'=>'Faculty Behavior','hostel'=>'Hostel','fees'=>'Fees','results'=>'Results','harassment'=>'Harassment','infrastructure'=>'Infrastructure (AC, Wi-Fi, furniture...)','other'=>'Other'] as $val => $label)
                        <option value="{{ $val }}" @selected(old('category')==$val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="scp-field-label">Title <span class="req">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required maxlength="150" placeholder="Brief subject of your complaint">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="scp-field-label">Priority <span class="req">*</span></label>
                    <select name="priority" class="form-select" required>
                        <option value="low" @selected(old('priority')=='low')>Low</option>
                        <option value="medium" @selected(old('priority', 'medium')=='medium')>Medium</option>
                        <option value="high" @selected(old('priority')=='high')>High</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="scp-field-label">Attachment (optional)</label>
                    <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                </div>
            </div>

            <div class="mb-3">
                <label class="scp-field-label">Description <span class="req">*</span></label>
                <textarea name="description" class="form-control" rows="5" required maxlength="5000" placeholder="Describe your complaint in detail...">{{ old('description') }}</textarea>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="is_anonymous" value="1" id="anon" @checked(old('is_anonymous'))>
                <label class="form-check-label small text-muted" for="anon">
                    Submit anonymously — your identity will not be stored with this complaint
                </label>
            </div>

            <button type="submit" class="btn-scp">Launch Complaint</button>
        </form>
    </div>
</div>
@endsection
