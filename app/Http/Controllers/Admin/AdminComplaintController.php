<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintStatusLog;
use App\Models\User;
use Illuminate\Http\Request;

class AdminComplaintController extends Controller
{
    // FR010 + FR013: view all complaints, filter by status/category/date/search
    public function index(Request $request)
    {
        $query = Complaint::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('complaint_code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $complaints = $query->paginate(15)->withQueryString();

        return view('admin.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load('statusLogs.changedByUser', 'student', 'assignedAdmin');
        $admins = User::where('role', 'admin')->get();

        return view('admin.complaints.show', compact('complaint', 'admins'));
    }

    // FR011 + FR012: respond to complaint, update status, add remarks
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,in_progress,resolved,rejected'],
            'admin_remarks' => ['nullable', 'string', 'max:2000'],
            'rejection_reason' => ['nullable', 'string', 'max:500', 'required_if:status,rejected'],
        ]);

        $complaint->status = $validated['status'];
        $complaint->admin_remarks = $validated['admin_remarks'] ?? $complaint->admin_remarks;
        $complaint->rejection_reason = $validated['status'] === 'rejected'
            ? ($validated['rejection_reason'] ?? null)
            : null;

        if ($validated['status'] === 'resolved') {
            $complaint->resolved_at = now();
        }

        $complaint->save();

        ComplaintStatusLog::create([
            'complaint_id' => $complaint->id,
            'status' => $validated['status'],
            'remarks' => $validated['admin_remarks'] ?? null,
            'changed_by' => $request->user()->id,
        ]);

        return back()->with('status', 'Complaint status updated.');
    }

    // FR014: assign complaint to an admin/department officer
    public function assign(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
        ]);

        $complaint->update(['assigned_to' => $validated['assigned_to']]);

        return back()->with('status', 'Complaint assigned.');
    }

    // FR014: delete an invalid/spam complaint
    public function destroy(Complaint $complaint)
    {
        $complaint->delete();

        return redirect()->route('admin.complaints.index')->with('status', 'Complaint deleted.');
    }
}
