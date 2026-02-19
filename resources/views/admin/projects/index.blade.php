@extends('layouts.app')

@section('title', 'Project Verification')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Project Verification</h1>
            <p class="text-gray-500 text-sm">Admin panel for verifying projects.</p>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('projects.index') }}" class="relative w-full md:w-64">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search project title..."
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">

            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Project</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $project->title }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $project->created_at->format('d M Y') }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @if ($project->status)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Verified
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Not Verified
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                @if (!$project->status)
                                    <form action="{{ route('admin.projects.verify', $project) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" onclick="return confirm('Verify this project?')"
                                            class="inline-flex items-center gap-2 
                       bg-green-600 hover:bg-green-700 
                       text-white font-semibold 
                       px-4 py-2 rounded-lg text-sm
                       shadow-sm transition duration-200
                       focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1">
                                            ✓ Verify ?
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.projects.unverify', $project) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" onclick="return confirm('Unverify this project?')"
                                            class="inline-flex items-center gap-2 
                       bg-red-500 hover:bg-red-600 
                       text-white font-semibold 
                       px-4 py-2 rounded-lg text-sm
                       shadow-sm transition duration-200
                       focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-1">
                                            ✕ Unverify ?
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-400">
                                No projects found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $projects->withQueryString()->links() }}
        </div>
    </div>
@endsection
