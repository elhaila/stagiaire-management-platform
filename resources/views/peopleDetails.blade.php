@extends('layouts.layout')

@section('content')
    <!-- Main Content -->
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 overflow-auto" style="padding-bottom: 100px">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Actions -->
            <div class="mb-8 flex justify-between items-start">
                <div>
                    <div class="flex items-center space-x-4 mb-2">
                        <a href="{{ route('peopleList') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </a>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Détails de la personne</h1>
                    </div>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Informations complètes sur le profil et l'historique</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('addDemande', $person->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Ajouter une demande
                    </a>
                    <a href="{{ route('editPerson', $person->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Modifier la personne
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Personal Information
                            </h2>
                        </div>
                        <div class="px-6 py-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome complet</p>
                                    <p class="text-lg text-gray-900 dark:text-gray-100 font-medium">{{ $person->fullname }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">CIN</p>
                                    <p class="text-lg text-gray-900 dark:text-gray-100 font-medium">{{ $person->cin }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $person->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Téléphone</p>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $person->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date d'inscription</p>
                                    @isset($person->created_at)
                                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $person->created_at->format('M d, Y') }}</p>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Demandes History -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                </svg>
                                Historique des demandes
                            </h2>
                        </div>
                        <div class="px-6 py-6">
                            @if($person->demandes->count() > 0)
                                <div class="space-y-6">
                                    @foreach($person->demandes->sortByDesc('created_at') as $demande)
                                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="flex items-center space-x-3">
                                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                                        @if($demande->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                        @elseif($demande->status === 'accepted') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                        @elseif($demande->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                        @elseif($demande->status === 'expired') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                                        @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                        @endif">
                                                        @if($demande->status == 'accepted') Actif
                                                        @elseif($demande->status == 'pending') en attente
                                                        @elseif($demande->status == 'rejected') rejeté
                                                        @elseif($demande->status == 'expired') expiré
                                                        @endif
                                                    </span>
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                        {{ ucfirst($demande->type) }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('showdemande', $demande->id) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm font-medium">
                                                        afficher les détails
                                                    </a>
                                                    @if($demande->cv)
                                                        <a href="{{ route('demande.downloadCV', $demande->id) }}" class="text-green-600 hover:text-green-800 dark:text-green-400 text-sm font-medium">
                                                            Download CV
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">université</p>
                                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $demande->university->name ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">diplôme</p>
                                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $demande->diplome->name ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">période</p>
                                                    <p class="text-sm text-gray-900 dark:text-gray-100">
                                                        @if($demande->start_date && $demande->end_date)
                                                            {{ \Carbon\Carbon::parse($demande->start_date)->format('M d, Y') }} - 
                                                            {{ \Carbon\Carbon::parse($demande->end_date)->format('M d, Y') }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            @if($demande->description)
                                                <div class="mb-4">
                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</p>
                                                    <p class="text-sm text-gray-900 dark:text-gray-100 mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">{{ $demande->description }}</p>
                                                </div>
                                            @endif

                                            <!-- Related Internships -->
                                            @if($demande->internships->count() > 0)
                                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Stages connexes ({{ $demande->internships->count() }})</p>
                                                    <div class="space-y-2">
                                                        @foreach($demande->internships as $internship)
                                                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                                                <div class="flex items-center justify-between">
                                                                    <div class="flex items-center space-x-2">
                                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                                            @if($internship->status ==     'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                                            @elseif($internship->status == 'finished') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                                            @elseif($internship->status == 'terminated') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                                            @elseif($internship->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                                            @endif">
                                                                                @if($internship->status == 'active') Actif
                                                                            @elseif($internship->status == 'finished') Terminé
                                                                            @elseif($internship->status == 'terminated') Clôturé
                                                                            @elseif($internship->status == 'pending') en attente
                                                                            @endif
                                                                        </span>
                                                                        <span class="text-sm text-gray-600 dark:text-gray-300">
                                                                            Supervisor: {{ $internship->user->name ?? 'N/A' }}
                                                                        </span>
                                                                    </div>
                                                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                                                        @if($internship->start_date && $internship->end_date)
                                                                            {{ \Carbon\Carbon::parse($internship->start_date)->format('M d, Y') }} - 
                                                                            {{ \Carbon\Carbon::parse($internship->end_date)->format('M d, Y') }}
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                @if($internship->absences->count() > 0)
                                                                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                                        Absences: {{ $internship->absences->count() }} 
                                                                        ({{ $internship->absences->where('status', 'justified')->count() }} justified)
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400 mx-auto mb-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0-1.125.504-1.125 1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">Aucune demande trouvée pour cette personne.</p>
                                    <a href="{{ route('addDemande', $person->id) }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                        Créer la première demande
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Absence History -->
                    @php
                        $allAbsences = $person->internships->flatMap->absences;
                    @endphp
                    @if($allAbsences->count() > 0)
                        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                    </svg>
                                    Historique des absences
                                </h2>
                            </div>
                            <div class="px-6 py-6">
                                <div class="space-y-4">
                                    @foreach($allAbsences->sortByDesc('date') as $absence)
                                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                        @if(empty($absence->end_date))
                                                            <span class="text-indigo-500">
                                                            @if($absence->start_date)
                                                                {{ \Carbon\Carbon::parse($absence->start_date)->format('M d, Y') }}
                                                            @endif
                                                            </span>
                                                        @elseif(!empty($absence->end_date))
                                                            du
                                                            <span class="text-indigo-500">
                                                            @if($absence->start_date)
                                                                {{ \Carbon\Carbon::parse($absence->start_date)->format('M d, Y') }}
                                                            @endif
                                                            </span>
                                                            au
                                                            <span class="text-indigo-500">
                                                            @if($absence->end_date)
                                                                {{ \Carbon\Carbon::parse($absence->endt_date)->format('M d, Y') }}
                                                            @endif
                                                            </span>
                                                        @endif
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if($absence->status == 'justified') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                        @endif">
                                                        @if($absence->status == 'justified')Justifié
                                                        @else Injustifié
                                                        @endif
                                                    </span>
                                                </div>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    stage #{{ $absence->internship_id }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                @if($absence->reason)
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">raison</p>
                                                        <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">{{ $absence->reason }}</p>
                                                    </div>
                                                @endif
                                                
                                                @if($absence->justification)
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">justification</p>
                                                        @if($absence->status === 'justified')
                                        <div class="mt-3 flex items-center space-x-4">
                                            <a href="{{ Storage::url($absence->justification) }}" target="_blank"
                                            class="inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Voir la justification
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">{{ $absence->justification }}</p>
                                    @endif
                                </div>
                            @endif
                            </div>

                                            <!-- Internship Context -->
                                            <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-600">
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-500 dark:text-gray-400">
                                                    <div>
                                                        <span class="font-medium">Période de stage :</span>
                                                        @if($absence->internship->start_date && $absence->internship->end_date)
                                                            {{ \Carbon\Carbon::parse($absence->internship->start_date)->format('M d, Y') }} - 
                                                            {{ \Carbon\Carbon::parse($absence->internship->end_date)->format('M d, Y') }}
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <span class="font-medium">Supervisor:</span>
                                                        {{ $absence->internship->user->name ?? 'Not assigned' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">statistiques rapides</h3>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total Demandes :</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $person->demandes->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total des stages :</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $person->internships->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total des absences :</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $allAbsences->count() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Status Breakdown -->
                    @if($person->demandes->count() > 0)
                        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Demandes Status</h3>
                            </div>
                            <div class="px-6 py-4 space-y-3">
                                @php
                                    $statusCounts = $person->demandes->groupBy('status');
                                @endphp
                                @foreach(['pending' => 'yellow', 'accepted' => 'green', 'rejected' => 'red', 'expired' => 'gray'] as $status => $color)
                                    @if($statusCounts->has($status))
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-300">
                                                    @if($status=='pending') En attente
                                                    @elseif($status=='accepted')Accepté
                                                    @elseif($status=='rejected')rejeté
                                                    @elseif($status=='expired')expiré
                                                    @endif
                                                </span>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $statusCounts[$status]->count() }}
                                            </span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Activity Timeline -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">activité récente</h3>
                        </div>
                        <div class="px-6 py-4">
                            <div class="flow-root">
                                <ul >
                                    <li>
                                        <div class="relative pb-8">
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600" aria-hidden="true"></span>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                        <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div>
                                                        <p class="text-sm text-gray-900 dark:text-gray-100">personne enregistrée</p>
                                                        @isset($person->created_at)
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $person->created_at->format('M d, Y \a\t H:i') }}</p>
                                                        @endisset
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @if($person->demandes->count() > 0)
                                        <li>
                                            <div class="relative pb-8">
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div>
                                                            <p class="text-sm text-gray-900 dark:text-gray-100">Dernière demande</p>
                                                            @if($person->demandes->sortByDesc('created_at')->first()->created_at)
                                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $person->demandes->sortByDesc('created_at')->first()->created_at->format('M d, Y \a\t H:i') }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if($person->updated_at != $person->created_at)
                                        <li>
                                            <div class="relative">
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div>
                                                            <p class="text-sm text-gray-900 dark:text-gray-100">dernière modification</p>
                                                            @if($person->updated_at)
                                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $person->updated_at->format('M d, Y \a\t H:i') }}</p>
                                                            @else
                                                                <p class="text-xs text-gray-500 dark:text-gray-400">N/A</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Absence Summary -->
                    @if($allAbsences->count() > 0)
                        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Résumé d'absence</h3>
                            </div>
                            <div class="px-6 py-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            justifié
                                        </span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $allAbsences->where('status', 'justified')->count() }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            non justifiée
                                        </span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $allAbsences->where('status', 'unjustified')->count() }}
                                    </span>
                                </div>
                                <div class="pt-2 border-t border-gray-200 dark:border-gray-600">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Absence récente :</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            @if($allAbsences->sortByDesc('date')->first())
                                                {{ \Carbon\Carbon::parse($allAbsences->sortByDesc('date')->first()->date)->format('M d, Y') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection