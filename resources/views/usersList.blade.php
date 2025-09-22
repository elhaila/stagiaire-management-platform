@extends('layouts.layout')
@section('content')
    <div class="p-6 space-y-6 overflow-auto">
        <div class="bg-white shadow rounded-lg p-4 flex flex-wrap gap-4 mt-6">
        <input type="text" placeholder="Search by name, university, diploma..."
               class="border rounded px-3 py-2 flex-1 min-w-[200px]">
        <select class="border rounded px-3 py-2">
            <option value="">All Types</option>
            <option value="PFE">PFE</option>
            <option value="Observation">Observation</option>
            <option value="Technique">Technique</option>
        </select>
        <select class="border rounded px-3 py-2">
            <option value="">All Users</option>
        </select>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
    </div>
    <h2 class="text-lg font-semibold mb-4  inline-block">User List</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase text-center">Full Name</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase text-center">Email</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase text-center">Role</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 text-center">
            @foreach ($users as $user)
                @if($user->id === auth()->user()->id)
                @continue
                @else
                    <tr>
                        <!-- Name -->
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $user->name ?? '—' }}
                        </td>
                        <!-- Email -->
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $user->email ?? '—' }}
                        </td>
                        <!-- Role -->
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $user->role ?? '—' }}
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div>
        {{$users->links()}}
    </div>

@endsection