<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    // FR007: My Complaints list + status tracking
    public function index(Request $request)
    {
        $complaints = Complaint::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('complaints.index', compact('complaints'));
    }

    // FR003/FR004: submission form (with anonymous toggle)
    public function create()
    {
        return view('complaints.create');
    }

    // FR003/FR004/FR005/FR006: store complaint, generate unique ID
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'category' => ['required', 'in:academics,faculty_behavior,hostel,fees,results,harassment,infrastructure,other'],
            'description' => ['required', 'string', 'max:5000'],
            'priority' => ['required', 'in:low,medium,high'],
            'is_anonymous' => ['nullable', 'boolean'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // 5MB, jpg/pdf per spec
        ]);

        $isAnonymous = $request->boolean('is_anonymous');

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('complaint-attachments', 'public');
        }

        $complaint = Complaint::create([
            'complaint_code' => Complaint::generateComplaintCode(),
            'user_id' => $isAnonymous ? null : $request->user()->id,
            'is_anonymous' => $isAnonymous,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'pending',
            'attachment_path' => $attachmentPath,
        ]);

        ComplaintStatusLog::create([
            'complaint_id' => $complaint->id,
            'status' => 'pending',
            'remarks' => 'Complaint submitted.',
            'changed_by' => $isAnonymous ? null : $request->user()->id,
        ]);

        return redirect()
            ->route('complaints.show', $complaint)
            ->with('status', "Complaint submitted successfully. Your tracking ID is {$complaint->complaint_code}.");
    }

    // FR007: view complaint details + history + status
    public function show(Request $request, Complaint $complaint)
    {
        // A student may only view their own (non-anonymous) complaints this way.
        if (! $request->user()->isAdmin() && $complaint->user_id !== $request->user()->id) {
            abort(403);
        }

        $complaint->load('statusLogs', 'assignedAdmin');

        return view('complaints.show', compact('complaint'));
    }

    // Public complaint tracking by code — works even for anonymous complaints (FR007)
    public function track(Request $request)
    {
        $complaint = null;
        $code = $request->query('code');

        if ($code) {
            $complaint = Complaint::where('complaint_code', $code)->with('statusLogs')->first();
        }

        return view('complaints.track', compact('complaint', 'code'));
    }

    // Student can edit their own complaint only while it's still pending (not yet accepted)
    public function edit(Request $request, Complaint $complaint)
    {
        if ($complaint->user_id !== $request->user()->id || $complaint->status !== 'pending') {
            abort(403, 'This complaint can no longer be edited.');
        }

        return view('complaints.edit', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        if ($complaint->user_id !== $request->user()->id || $complaint->status !== 'pending') {
            abort(403, 'This complaint can no longer be edited.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'category' => ['required', 'in:academics,faculty_behavior,hostel,fees,results,harassment,infrastructure,other'],
            'description' => ['required', 'string', 'max:5000'],
            'priority' => ['required', 'in:low,medium,high'],
        ]);

        $complaint->update($validated);

        return redirect()->route('complaints.show', $complaint)->with('status', 'Complaint updated.');
    }
}
