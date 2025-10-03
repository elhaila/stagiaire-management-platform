@extends('layouts.layout')

@section('content')
<div class="p-6 space-y-6 overflow-auto">

    <!-- Key Metrics -->
    <div class="flex flex-wrap gap-6">
        <div class="flex-1 min-w-[200px] bg-white shadow rounded-lg p-4 dark:bg-gray-700">
            <div class="text-gray-500 text-sm dark:text-gray-400">Nombre total de stages</div>
            <div class="text-2xl font-bold dark:text-black">{{ $totalInternships }}</div>
        </div>
        <div class="flex-1 min-w-[200px] bg-white shadow rounded-lg p-4 dark:bg-gray-700">
            <div class="text-gray-500 text-sm dark:text-gray-400">Stages actifs</div>
            <div class="text-2xl font-bold text-green-600">{{ $activeInternships }}</div>
        </div>
        <div class="flex-1 min-w-[200px] bg-white shadow rounded-lg p-4 dark:bg-gray-700">
            <div class="text-gray-500 text-sm dark:text-gray-400">Stages en attente</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $pendingInternships }}</div>
        </div>
        <div class="flex-1 min-w-[200px] bg-white shadow rounded-lg p-4 dark:bg-gray-700">
            <div class="text-gray-500 text-sm dark:text-gray-400">Stages terminés</div>
            <div class="text-2xl font-bold text-blue-600">{{ $totalFinishedInternships }}</div>
        </div>
    </div>

    <!-- Recent Internships -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 overflow-x-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">stages récents</h2>
            <a href="{{ route('internshipList') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Tout afficher</a>
        </div>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">stagiaire</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Supervisor</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Type</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Statut</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date de debut</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date de fin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($recentInternships as $internship)
                    <tr>
                        <td class="px-4 py-2 text-sm flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                                    {{ substr($demande->person->fullname ?? 'N', 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-white name-highlight">
                                    {{ $internship->demande->person->fullname ?? '—' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-400">
                            {{ $internship->user->name ?? '—' }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-400">
                            {{ ucfirst($internship->demande->type ?? '—') }}
                        </td>
                        <td class="px-4 py-2">
                            <span class="inline-flex items-center px-2 py-1 text-xs rounded-full font-medium
                                @if($internship->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @elseif($internship->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                @elseif($internship->status === 'finished') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                @elseif($internship->status === 'terminated') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @endif">
                                @if($internship->status === 'active')
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>Actif
                                @elseif($internship->status === 'pending')
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>Pendant
                                @elseif($internship->status === 'finished')
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>Complété
                                @elseif($internship->status === 'terminated')
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>Clôturé
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($internship->start_date)->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($internship->end_date)->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            No internships found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent Absences -->
    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto dark:bg-gray-800">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold dark:text-white">Recent Absences</h2>
            <a href="{{route('absenceList')}}" class="text-blue-600 hover:underline text-sm">Tout afficher</a>
        </div>
        
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700 dark:divide-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">stagiaire</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">raison</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">justification</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($recentAbsences as $absence)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-700 flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                                    {{ substr($absence->internship->demande->person->fullname  ?? 'N', 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900 name-highlight dark:text-white">
                                    {{ $absence->internship->demande->person->fullname ?? '—' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-400">
                            @if($absence->end_date != null )
                                {{ \Carbon\Carbon::parse($absence->start_date)->format('M d, Y') }} <strong>au</strong>
                                {{ \Carbon\Carbon::parse($absence->end_date)->format('M d, Y') }}
                            @elseif($absence->start_date != null)
                                {{ \Carbon\Carbon::parse($absence->start_date)->format('M d, Y') }}
                            
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-400">
                            {{ $absence->reason ?? '—' }}
                        </td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded
                                @if($absence->status === 'justified') bg-green-100 text-green-800
                                @elseif($absence->status === 'unjustified') bg-red-100 text-red-800
                                @endif">
                                @if($absence->status === 'justified') justifié 
                                @else injustifié
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-400">
                            {{ $absence->justification ? 'OUI' : 'NO' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            Aucune absence trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection