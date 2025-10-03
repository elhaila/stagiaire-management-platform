@extends('layouts.layout')
@section('content')

    <!-- Main Content -->
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 overflow-auto" style="padding-bottom: 100px">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Actions -->
            <div class="mb-8 flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Demande Details</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Complétez les informations sur la demande de stage</p>
                </div>
                <div class="flex space-x-3">
                    @if($demande->status === 'pending')
                        <button onclick="openApprovalModal({{ $demande->id }}, '{{ $demande->person->fullname ?? '' }}')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            approuver
                        </button>
                        
                        <form action="{{ route('updateDemande', $demande->id) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                rejeter
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('editDemande', $demande->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        modifier
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
                                information personnelle
                            </h2>
                        </div>
                        <div class="px-6 py-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">nom complet</p>
                                    <p class="text-lg text-gray-900 dark:text-gray-100 font-medium">{{ $demande->person->fullname ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $demande->person->email ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">téléphone</p>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $demande->person->phone ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">CIN</p>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $demande->person->cin ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Status Card -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                </svg>
                                Demande Details
                            </h2>
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($demande->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                @elseif($demande->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @elseif($demande->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                @elseif($demande->status === 'expired') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                @endif">
                                @if($demande->status == 'approved') approuvé
                                @elseif($demande->status == 'pending') en attente
                                @elseif($demande->status == 'rejected') rejeté
                                @elseif($demande->status == 'expired') expiré
                                @endif
                            </span>
                        </div>
                        <div class="px-6 py-6">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        {{ ucfirst($demande->type) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">date de début</p>
                                    @if($demande->start_date != null)
                                        <p class="text-lg text-gray-900 dark:text-gray-100 font-medium">
                                            {{ \Carbon\Carbon::parse($demande->start_date)->format('M d, Y') }}
                                        </p>
                                    @else
                                        <p class="text-lg text-gray-900 dark:text-gray-100 font-medium">_</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">date de fin</p>
                                    @if($demande->end_date != null)
                                        <p class="text-lg text-gray-900 dark:text-gray-100 font-medium">
                                            {{ \Carbon\Carbon::parse($demande->end_date)->format('M d, Y') }}
                                        </p>
                                    @else
                                        <p class="text-lg text-gray-900 dark:text-gray-100 font-medium">_</p>
                                    @endif
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">durée</p>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    @if($demande->start_date != null && $demande->end_date != null)
                                        {{ \Carbon\Carbon::parse($demande->start_date)->diffInDays(\Carbon\Carbon::parse($demande->end_date)) }} jours
                                        ({{ \Carbon\Carbon::parse($demande->start_date)->diffForHumans(\Carbon\Carbon::parse($demande->end_date), true) }})
                                    @else
                                        _
                                    @endif
                                </p>
                            </div>
                            @if($demande->description)
                            <div class="mt-6">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</p>
                                <p class="text-sm text-gray-900 dark:text-gray-100 mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                                    {{ $demande->description }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                information académique
                            </h2>
                        </div>
                        <div class="px-6 py-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">université</p>
                                    <p class="text-lg text-gray-900 dark:text-gray-100 font-medium">{{ $demande->university->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">diplôme</p>
                                    <p class="text-lg text-gray-900 dark:text-gray-100 font-medium">{{ $demande->diplome->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">academic city</p>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $demande->university->city ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- CV Download -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Documents</h3>
                        </div>
                        <div class="px-6 py-4">
                            @if($demande->cv != 'cv.pdf' && $demande->cv != null)
                            <div class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-600 rounded-lg">
                                <div class="flex items-center">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
 
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">CV.pdf</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Document PDF</p>
                                    </div>
                                </div>
                                <a href="{{ route('demande.downloadCV', $demande->id) }}?v={{ $demande->updated_at->timestamp }}" 
                                   class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Pas de CV téléchargé</p>
                            </div>
                            @endif
                            @if($demande->cv)
                                <div class="mt-3 flex items-center space-x-4">
                                    <a href="{{ Storage::url($demande->cv) }}" target="_blank"
                                       class="inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Afficher le CV actuel
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">statistiques rapides</h3>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Jours jusqu'au début :</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    @if(\Carbon\Carbon::parse($demande->start_date)->isFuture())
                                        {{ number_format(\Carbon\Carbon::now()->floatDiffInDays(\Carbon\Carbon::parse($demande->start_date)), 2) }} jours
                                    @else
                                        démarré
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Jours jusqu'à la fin :</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                @if(\Carbon\Carbon::parse($demande->end_date)->isFuture())
                                    {{ round(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($demande->end_date))) }} jours
                                @else
                                    terminé
                                @endif
                            </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Temps depuis la demande :</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    @if($demande->created_at != null)
                                        {{ $demande->created_at->diffForHumans() }}
                                    @else
                                        _
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Timeline -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Activité</h3>
                        </div>
                        <div class="px-6 py-4">
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    <li>
                                        <div class="relative pb-8">
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
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
                                                        <p class="text-sm text-gray-900 dark:text-gray-100">Demande créée</p>
                                                        @if($demande->created_at != null)
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $demande->created_at->format('M d, Y \a\t H:i') }}</p>
                                                        @else
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">_</p>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @if($demande->updated_at != $demande->created_at)
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
                                                        <p class="text-sm text-gray-900 dark:text-gray-100">dernière modification</p>
                                                        @if($demande->updated_at != null)
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $demande->updated_at->format('M d, Y \a\t H:i') }}</p>
                                                        @else
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">_</p>
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
                </div>
            </div>
        </div>
    </div>
        <!-- Approval Modal -->
    <div id="approvalModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-start justify-center z-50 pt-8">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">Approuver la demande</h3>
                    <button onclick="closeApprovalModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1 rounded-full hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Approval Form -->
                <form id="approvalForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-5">
                        <!-- Full Name (Read-only) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">nom complet</label>
                            <input type="text" id="modal_fullname" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   readonly>
                        </div>
                        {{-- Project name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">nom du projet</label>
                            <input type="text" id="Project" name="Project"  
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" >
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                date de début du stage <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="modal_start_date" name="internship_start_date" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                required>
                        </div>

                        <!-- End Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Date de fin du stage <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="modal_end_date" name="internship_end_date" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   required>
                        </div>

                        <!-- Status (Auto-calculated) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut du stage</label>
                            <input type="text" id="modal_status" name="internship_status" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   readonly>
                        </div>
                        
                        <!-- Supervisor Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                superviseur <span class="text-red-500">*</span>
                            </label>
                            <select name="supervisor_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white" 
                                    required>
                                <option value="">Sélectionner le superviseur</option>
                                @if(isset($users))
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <!-- Hidden fields -->
                    <input type="hidden" name="status" value="accepted">
                    <input type="hidden" name="create_internship" value="1">

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end space-x-3 mt-8 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeApprovalModal()" 
                                class="px-5 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                            annuler
                        </button>
                        <button type="submit" 
                                class="px-5 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                            Approuver et créer un stage
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
    .modal-enter {
        opacity: 1;
        transform: scale(1);
    }

    .modal-exit {
        opacity: 0;
        transform: scale(0.95);
    }

    #modalContent::-webkit-scrollbar {
        width: 6px;
    }

    #modalContent::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    #modalContent::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    #modalContent::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Form input focus states */
    input:focus, select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Button hover effects */
    button:hover {
        transform: translateY(-1px);
    }

    button:active {
        transform: translateY(0);
    }

    /* Responsive improvements */
    @media (max-width: 640px) {
        #modalContent {
            margin: 1rem;
            max-width: calc(100vw - 2rem);
        }
        
        .modal-footer {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .modal-footer button {
            width: 100%;
        }
    }
    </style>

    <script>
        function openApprovalModal(demandeId, fullname) {
            // Set form action URL
            document.getElementById('approvalForm').action = `/demande/${demandeId}`;
            
            // Fill form fields
            document.getElementById('modal_fullname').value = fullname;
            
            // Calculate and set initial status
            updateInternshipStatus();
            
            // Show modal with animation
            const modal = document.getElementById('approvalModal');
            const modalContent = document.getElementById('modalContent');
            
            modal.classList.remove('hidden');
            
            // Trigger animation
            setTimeout(() => {
                modalContent.classList.add('modal-enter');
                modalContent.classList.remove('scale-95', 'opacity-0');
            }, 10);
            
            // Focus on first input
            setTimeout(() => {
                document.getElementById('modal_start_date').focus();
            }, 150);
        }

        function closeApprovalModal() {
            const modal = document.getElementById('approvalModal');
            const modalContent = document.getElementById('modalContent');
            
            // Animate out
            modalContent.classList.remove('modal-enter');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                // Clear form
                document.getElementById('approvalForm').reset();
            }, 150);
        }

        function updateInternshipStatus() {
            const startDateInput = document.getElementById('modal_start_date');
            const statusInput = document.getElementById('modal_status');
            const startDate = new Date(startDateInput.value);
            const today = new Date();
            const endDate = new Date(document.getElementById('modal_end_date').value);
            
            // Set time to 00:00:00 for accurate date comparison
            today.setHours(0, 0, 0, 0);
            startDate.setHours(0, 0, 0, 0);
            endDate.setHours(0, 0, 0, 0);
            
            if (!startDateInput.value) {
                statusInput.value = '';
                return;
            }
            
            if (startDate > today) {
                statusInput.value = 'pending';
            } else if (startDate <= today && endDate >= today) {
                statusInput.value = 'active';
            } else if (endDate < today) {
                statusInput.value = 'finished';
            } else {
                statusInput.value = 'pending';
            }
        }

        // Enhanced event listeners
        document.addEventListener('DOMContentLoaded', function() {
            setDateConstraints();
            document.getElementById('modal_start_date').addEventListener('change', updateInternshipStatus);
            document.getElementById('modal_end_date').addEventListener('change', updateInternshipStatus);
            
            // Close modal when clicking backdrop
            document.getElementById('approvalModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeApprovalModal();
                }
            });
            
            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !document.getElementById('approvalModal').classList.contains('hidden')) {
                    closeApprovalModal();
                }
            });
            
            // Form validation before submit
            // Form validation before submit
            document.getElementById('approvalForm').addEventListener('submit', function(e) {
                const startDate = document.getElementById('modal_start_date').value;
                const endDate = document.getElementById('modal_end_date').value;
                const supervisor = document.querySelector('select[name="supervisor_id"]').value;
                
                if (!startDate || !endDate || !supervisor) {
                    e.preventDefault();
                    alert('Please fill all required fields');
                    return false;
                }
                
                const startDateObj = new Date(startDate);
                const endDateObj = new Date(endDate);
                const diffTime = Math.abs(endDateObj - startDateObj);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (startDateObj >= endDateObj) {
                    e.preventDefault();
                    alert('End date must be after start date');
                    return false;
                }
                
                if (diffDays < 30) {
                    e.preventDefault();
                    alert('Internship duration must be at least 30 days');
                    return false;
                }
            });
        });

        function setDateConstraints() 
        {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const tomorrowStr = tomorrow.toISOString().split('T')[0];
            
            const startDateInput = document.getElementById('modal_start_date');
            const endDateInput = document.getElementById('modal_end_date');
            
            // Set minimum date to tomorrow
            startDateInput.min = tomorrowStr;
            
            // When start date changes, set end date minimum to 30 days later
            startDateInput.addEventListener('change', function() {
                if (this.value) {
                    const startDate = new Date(this.value);
                    const minEndDate = new Date(startDate);
                    minEndDate.setDate(minEndDate.getDate() + 30);
                    const minEndDateStr = minEndDate.toISOString().split('T')[0];
                    
                    endDateInput.min = minEndDateStr;
                    endDateInput.value = ''; // Clear end date when start date changes
                    
                    updateInternshipStatus();
                }
            });
        }
    </script>
@endsection