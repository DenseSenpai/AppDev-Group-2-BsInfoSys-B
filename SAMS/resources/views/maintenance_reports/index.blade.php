<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4 text-white">Maintenance Reports</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Student: Report Issue --}}
        @if(auth()->user()->isStudent())
            <div class="bg-white p-4 rounded shadow mb-6">
                <h2 class="font-semibold text-lg mb-2">Report an Issue</h2>
                <form action="{{ route('maintenance_reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block font-medium">Room</label>
                        <select name="room_id" class="border rounded px-2 py-1 w-full">
                            <option value="{{ auth()->user()->boarder->room->id ?? '' }}">
                                Room {{ auth()->user()->boarder->room->room_number ?? 'N/A' }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium">Category</label>
                        <input type="text" name="category" class="border rounded px-2 py-1 w-full" placeholder="e.g. Plumbing, Electricity">
                    </div>
                    <div>
                        <label class="block font-medium">Description</label>
                        <textarea name="description" class="border rounded px-2 py-1 w-full" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block font-medium">Upload Media (optional)</label>
                        <input type="file" name="media[]" multiple class="border rounded px-2 py-1 w-full">
                    </div>
                    <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded">Submit</button>
                </form>
            </div>
        @endif

        {{-- Reports Table (Admin & Student see differently) --}}
        <table class="w-full bg-white rounded shadow">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2">Category</th>
                    <th class="p-2">Description</th>
                    <th class="p-2">Room</th>
                    @if(auth()->user()->isAdmin())
                        <th class="p-2">Boarder</th>
                        <th class="p-2">Assigned To</th>
                    @endif
                    <th class="p-2">Status</th>
                    @if(auth()->user()->isAdmin())
                        <th class="p-2">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr class="border-t">
                        <td class="p-2">{{ $report->category }}</td>
                        <td class="p-2">{{ $report->description }}</td>
                        <td class="p-2">Room {{ $report->room->room_number ?? 'N/A' }}</td>

                        @if(auth()->user()->isAdmin())
                            <td class="p-2">{{ $report->boarder->first_name ?? 'N/A' }}</td>
                            <td class="p-2">{{ $report->assignedStaff->name ?? 'Unassigned' }}</td>
                        @endif

                        <td class="p-2">{{ ucfirst($report->status) }}</td>

                        @if(auth()->user()->isAdmin())
                            <td class="p-2">
                                <form action="{{ route('maintenance_reports.updateStatus', $report->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                                        <option value="open" {{ $report->status == 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="in_progress" {{ $report->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="closed" {{ $report->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">
                            No maintenance reports found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    </div>
</x-app-layout>
