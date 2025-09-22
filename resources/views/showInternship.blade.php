@extends('layouts.layout')

@section('content')
<div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-8 overflow-auto">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Internship Details
            </h1>
        </div>
        
        {{-- Main Action Buttons --}}
        <div class="flex space-x-3 mt-4 sm:mt-0">
            <a href="{{ route('editInternship', $internships->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                </svg>
                Edit
            </a>
            @if($internships->status != 'finished' && $internships->status != 'pending' && $internships->status != 'terminated')
                <a href="{{ route('CreateAbsence', $internships->id) }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                    Absence
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left Column: Overview & Documents --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Overview Card --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Overview</h2>
                    
                    {{-- Using a grid for a more robust key-value layout --}}
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6 text-sm">
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">University</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">{{ $internships->demande->university->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Diploma</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">{{ $internships->demande->diplome->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Internship Type</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">{{ $internships->demande->type }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Status</dt>
                            <dd class="mt-1">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    @if($internships->status == 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($internships->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($internships->status == 'finished') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                    {{ ucfirst($internships->status) }}
                                </span>
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Start Date</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($internships->start_date)->format('F j, Y') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">End Date</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($internships->end_date)->format('F j, Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Documents Card --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Documents</h2>
                    <ul class="space-y-4">
                        {{-- CV --}}
                        <li class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Curriculum Vitae (CV)</p>
                                    @if($internships->demande->cv)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Uploaded on {{ $internships->demande->updated_at->format('M d, Y') }}</p>
                                    @else
                                        <p class="text-xs text-red-500 dark:text-red-400">Not Uploaded</p>
                                    @endif
                                </div>
                            </div>
                            @if($internships->demande->cv)
                                <a href="{{ route('demande.downloadCV', $internships->demande->id) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm font-semibold">Download</a>
                                @if($internships->demande->cv)
                                        <a href="{{ Storage::url($internships->demande->cv) }}" target="_blank"
                                        class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm font-semibold">
                                            View Current CV
                                        </a>
                                @endif
                            @endif
                        </li>
                        
                        {{-- date deposite Fiche Fin de Stage --}}
                        <li class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L15.232 5.232z" />
                                </svg>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">End-of-Internship Form</p>
                                    @if($internships->date_fiche_fin_stage)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Submitted on: {{ \Carbon\Carbon::parse($internships->date_fiche_fin_stage)->format('M d, Y') }}</p>
                                    @else
                                        <p class="text-xs text-red-500 dark:text-red-400">Not Submitted</p>
                                    @endif
                                </div>
                            </div>
                        </li>

                        {{-- Rapport --}}
                        <li class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Internship Report</p>
                                    @if($internships->date_depot_rapport_stage)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Submitted on: {{ \Carbon\Carbon::parse($internships->date_depot_rapport_stage)->format('M d, Y') }}</p>
                                    @else
                                        <p class="text-xs text-red-500 dark:text-red-400">Not Submitted</p>
                                    @endif
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        {{-- Right Column: Absences --}}
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Absences</h2>
                    @if($internships->absences->count() > 0)
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @foreach($internships->absences as $absence)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div class="flex items-center">
                                                <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-gray-800 {{ $absence->status == 'justified' ? 'bg-green-500' : 'bg-red-500' }}">
                                                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-800 dark:text-gray-200">{{ $absence->reason ?? 'No reason provided' }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($absence->date)->format('F j, Y') }}</p>
                                                </div>
                                                <div class="text-right text-xs whitespace-nowrap text-gray-500">
                                                    <span class="{{ $absence->status == 'justified' ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ ucfirst($absence->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="text-center py-10" >
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                              <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No absences</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This intern has a perfect attendance record.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection