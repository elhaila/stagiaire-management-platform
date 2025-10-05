@extends('layouts.layout')

@section('content')
<div class="p-4 sm:p-6 space-y-6">

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white shadow rounded-lg p-4 dark:bg-gray-700">
            <div class="text-gray-500 text-sm dark:text-gray-400">Nombre total de stages</div>
            <div class="text-2xl font-bold dark:text-black">{{ $totalInternships }}</div>
        </div>
        <div class="bg-white shadow rounded-lg p-4 dark:bg-gray-700">
            <div class="text-gray-500 text-sm dark:text-gray-400">Stages actifs</div>
            <div class="text-2xl font-bold text-green-600">{{ $activeInternships }}</div>
        </div>
        <div class="bg-white shadow rounded-lg p-4 dark:bg-gray-700">
            <div class="text-gray-500 text-sm dark:text-gray-400">Stages en attente</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $pendingInternships }}</div>
        </div>
        <div class="bg-white shadow rounded-lg p-4 dark:bg-gray-700">
            <div class="text-gray-500 text-sm dark:text-gray-400">Stages terminés</div>
            <div class="text-2xl font-bold text-blue-600">{{ $totalFinishedInternships }}</div>
        </div>
    </div>

    <!-- Recent Internships -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 overflow-x-auto">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Stages récents</h2>
            <a href="{{ route('internshipList') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Tout afficher</a>
        </div>

        <div class="overflow-x-auto hidden sm:block">
            <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase">Stagiaire</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase">Superviseur</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase">Type</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase">Statut</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase">Début</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase">Fin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($recentInternships as $internship)
                        <tr>
                            <td class="px-3 py-2 flex items-center gap-2">
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                                    {{ substr($internship->demande->person->fullname ?? 'N', 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ $internship->demande->person->fullname ?? '—' }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-400">{{ $internship->user->name ?? '—' }}</td>
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-400">{{ ucfirst($internship->demande->type ?? '—') }}</td>
                            <td class="px-3 py-2">
                                <span class="inline-flex items-center px-2 py-1 text-xs rounded-full font-medium
                                    @if($internship->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                    @elseif($internship->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                    @elseif($internship->status === 'finished') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                    {{ ucfirst($internship->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-400">{{ \Carbon\Carbon::parse($internship->start_date)->format('M d, Y') }}</td>
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-400">{{ \Carbon\Carbon::parse($internship->end_date)->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-6 text-center text-gray-500 dark:text-gray-400">Aucun stage trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Mobile Cards -->
        <div class="space-y-3 sm:hidden">
            @foreach($recentInternships as $internship)
                <div class="bg-gray-50 dark:bg-gray-700 shadow rounded-lg p-3 space-y-1">
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-900 dark:text-white">
                            {{ $internship->demande->person->fullname ?? '—' }}
                        </span>
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($internship->status === 'active') bg-green-100 text-green-800 
                            @elseif($internship->status === 'pending') bg-yellow-100 text-yellow-800 
                            @elseif($internship->status === 'finished') bg-red-100 text-red-800 
                            @endif">
                            {{ ucfirst($internship->status) }}
                        </span>
                    </div>
                    <div class="text-gray-600 dark:text-gray-300 text-sm">
                        <p><span class="font-medium">Superviseur:</span> {{ $internship->user->name ?? '—' }}</p>
                        <p><span class="font-medium">Type:</span> {{ ucfirst($internship->demande->type ?? '—') }}</p>
                        <p><span class="font-medium">Période:</span> 
                            {{ \Carbon\Carbon::parse($internship->start_date)->format('M d, Y') }}
                            - {{ \Carbon\Carbon::parse($internship->end_date)->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <!-- Recent Absences -->
    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto dark:bg-gray-800">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 mb-4">
            <h2 class="text-lg font-semibold dark:text-white">Absences récentes</h2>
            <a href="{{ route('absenceList') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Tout afficher</a>
        </div>
        
        <div class="overflow-x-auto hidden sm:block ">
            <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Stagiaire</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Raison</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Justification</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($recentAbsences as $absence)
                        <tr>
                            <td class="px-3 py-2 flex items-center gap-2">
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                                    {{ substr($absence->internship->demande->person->fullname ?? 'N', 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ $absence->internship->demande->person->fullname ?? '—' }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-400">
                                @if($absence->end_date)
                                    {{ \Carbon\Carbon::parse($absence->start_date)->format('M d, Y') }} au {{ \Carbon\Carbon::parse($absence->end_date)->format('M d, Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($absence->start_date)->format('M d, Y') }}
                                @endif
                            </td>
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-400">{{ $absence->reason ?? '—' }}</td>
                            <td class="px-3 py-2">
                                <span class="px-2 py-1 text-xs rounded 
                                    @if($absence->status === 'justified') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $absence->status === 'justified' ? 'Justifié' : 'Injustifié' }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-gray-700 dark:text-gray-400">{{ $absence->justification ? 'Oui' : 'Non' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-6 text-center text-gray-500 dark:text-gray-400">Aucune absence trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Mobile Cards -->
<div class="sm:hidden space-y-3">
    @foreach($recentAbsences as $absence)
        <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-3 space-y-1">
            <div class="flex justify-between items-center">
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ $absence->internship->demande->person->fullname ?? '—' }}
                </span>
                <span class="text-xs px-2 py-1 rounded 
                    @if($absence->status === 'justified') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ $absence->status === 'justified' ? 'Justifié' : 'Injustifié' }}
                </span>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-300"><b>Date:</b>
                @if($absence->end_date)
                    {{ \Carbon\Carbon::parse($absence->start_date)->format('M d, Y') }} – 
                    {{ \Carbon\Carbon::parse($absence->end_date)->format('M d, Y') }}
                @else
                    {{ \Carbon\Carbon::parse($absence->start_date)->format('M d, Y') }}
                @endif
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-300"><b>Raison:</b> {{ $absence->reason ?? '—' }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-300"><b>Justification:</b> {{ $absence->justification ? 'Oui' : 'Non' }}</p>
        </div>
    @endforeach
</div>
    </div>
</div>
@endsection
