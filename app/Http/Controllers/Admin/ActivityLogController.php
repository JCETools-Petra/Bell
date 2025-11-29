<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Only admin can view all activity logs
        if (! Gate::allows('admin')) {
            abort(403, 'Unauthorized access to activity logs.');
        }

        $query = ActivityLog::with('user');

        // Filter by action type
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->latest()->paginate(20);

        // Get unique actions for filter dropdown
        $actions = ActivityLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        // Get users who have activity logs
        $users = \App\Models\User::whereIn('id', function($query) {
            $query->select('user_id')
                ->from('activity_logs')
                ->distinct();
        })->get(['id', 'name']);

        return view('admin.activity-logs.index', compact('logs', 'actions', 'users'));
    }

    public function show(ActivityLog $activityLog)
    {
        if (! Gate::allows('admin')) {
            abort(403);
        }

        $activityLog->load('user');
        return view('admin.activity-logs.show', compact('activityLog'));
    }
}
