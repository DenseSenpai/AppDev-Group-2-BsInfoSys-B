<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceReport;
use Illuminate\Http\Request;

class MaintenanceReportController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $reports = MaintenanceReport::with(['boarder.room', 'assignedStaff'])->latest()->paginate(15);
        } else {
            $reports = MaintenanceReport::with('room')
                ->where('boarder_id', auth()->user()->boarder->id ?? null)
                ->latest()
                ->paginate(15);
        }

        return view('maintenance_reports.index', compact('reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'media.*' => 'nullable|file|mimes:jpg,png,jpeg,mp4|max:2048',
        ]);

        $mediaPaths = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mediaPaths[] = $file->store('maintenance_media', 'public');
            }
        }

        MaintenanceReport::create([
            'boarder_id' => auth()->user()->boarder->id ?? null,
            'room_id' => $request->room_id,
            'category' => $request->category,
            'description' => $request->description,
            'media' => $mediaPaths,
            'status' => 'open',
        ]);

        return back()->with('success', 'Maintenance report submitted.');
    }

    public function updateStatus(Request $request, MaintenanceReport $report)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed'
        ]);

        $report->update(['status' => $request->status]);

        return back()->with('success', "Report status updated.");
    }
}
