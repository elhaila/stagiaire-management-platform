@extends('layouts.layout')
@section('content')
    <style>
        .scroll-hint::after {
            content: "";
            position: absolute;
            right: 0;
            top: 0;
            width: 20px;
            height: 100%;
            background: linear-gradient(to left, rgba(0,0,0,0.1), transparent);
            pointer-events: none;
        }
    </style>
    <div class="p-6 space-y-6 overflow-auto">
        <!-- Enhanced Search Section -->
        <div class="bg-white shadow rounded-lg p-4 mt-6 dark:bg-gray-800">
            <div class="flex flex-wrap gap-4 items-center ">
                <!-- Real-time Search Input -->
                <div class="flex-1 min-w-[250px] relative">
                    <input type="text" 
                           id="search-input" 
                           placeholder="Search by name, university, diploma, type..." 
                           class="w-full border rounded px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-transparent dark:text-white">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Type Filter -->
                <select id="type-filter" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-800 dark:text-white">
                    <option value="">toute sorte</option>
                    <option value="pfe">PFE</option>
                    <option value="stage">Stage</option>
                </select>

                <!-- Status Filter -->
                <select id="status-filter" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-800 dark:text-white">
                    <option value="">tous les statuts</option>
                    <option value="pending">en attente</option>
                    <option value="expired">expiré</option>
                    <option value="rejected">rejeté</option>
                </select>

                <!-- Sort Options -->
                <select id="sort-select" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-800 dark:text-white">
                    <option value="name-asc">Nome A-Z</option>
                    <option value="name-desc">Nome Z-A</option>
                    <option value="date-newest">plus récent en premier</option>
                    <option value="date-oldest">plus ancien en premier</option>
                    <option value="start-earliest">Date de début (la plus proche)</option>
                    <option value="start-latest">Date de début (Dernière)</option>
                    <option value="status-priority" selected>Statut Priorité</option>
                </select>

                <!-- Clear Search -->
                <button id="clear-search" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors duration-200">
                    Clair
                </button>
            </div>
            
            <!-- Search Statistics -->
            <div class="mt-3 flex items-center justify-between text-sm text-gray-600">
                <span id="search-stats">Affichage de {{ $demandes->where('status', '!=', 'accepted')->count() }} personnes sur {{ $demandes->where('status', '!=', 'accepted')->count() }} demandes</span>
                {{-- <span id="search-time" class="hidden">Search completed in <span id="search-duration">0</span>ms</span> --}}
            </div>
        </div>

        <h2 class="text-lg font-semibold mb-4 inline-block dark:text-white">List des demande</h2>

        <!-- Results Container -->
       <div class="bg-white shadow rounded-lg overflow-hidden dark:bg-gray-800" style="font-size: small">
            <div class="overflow-x-scroll relative scroll-hint">
                <table class="min-w-full table-auto divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700 ">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer dark:text-gray-400" 
                                onclick="sortTable('name')">
                                nom complet
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer dark:text-gray-400"
                                onclick="sortTable('university')">
                                université
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">diplôme</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Type</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer dark:text-gray-400"
                                onclick="sortTable('status')">
                                statut
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer dark:text-gray-400"
                                onclick="sortTable('start')">
                                date de début
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">date de fin</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">actions</th>
                        </tr>
                    </thead>
                    
                    <tbody id="demandes-table-body" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach ($demandes as $demande)
                            @if($demande->status != 'accepted')
                            <tr class="demande-row  transition-colors duration-150" 
                                data-name="{{ strtolower($demande->person->fullname ?? '') }}" 
                                data-university="{{ strtolower($demande->university->name ?? '') }}" 
                                data-diploma="{{ strtolower($demande->diplome->name ?? '') }}" 
                                data-type="{{ strtolower($demande->type ?? '') }}" 
                                data-status="{{ strtolower($demande->status ?? '') }}"
                                data-start-date="{{ $demande->start_date ?? '' }}"
                                data-end-date="{{ $demande->end_date ?? '' }}"
                                data-created="{{ $demande->created_at }}"
                                data-search-text="{{ strtolower(($demande->person->fullname ?? '') . ' ' . ($demande->university->name ?? '') . ' ' . ($demande->diplome->name ?? '') . ' ' . ($demande->type ?? '')) }}">
                                
                                <!-- Person -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                                                {{ substr($demande->person->fullname ?? 'N', 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-gray-900 name-highlight dark:text-gray-400">
                                                {{ $demande->person->fullname ?? '—' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- University -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <span class="university-highlight dark:text-gray-400">{{ $demande->university->name ?? '—' }}</span>
                                </td>

                                <!-- Diploma -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <span class="diploma-highlight dark:text-gray-400">{{ $demande->diplome->name ?? '—' }}</span>
                                </td>

                                <!-- Type -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ strtolower($demande->type) === 'pfe' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        <span class="type-highlight">{{ ucfirst($demande->type) }}</span>
                                    </span>
                                </td>

                                <!-- Status (with badge style) -->
                                <td class="px-4 py-2">
                                    <span class="inline-flex items-center px-2 py-1 text-xs rounded-full font-medium
                                        @if($demande->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($demande->status === 'expired') bg-amber-200 text-amber-800
                                        @elseif($demande->status === 'rejected') bg-red-100 text-red-800
                                        @endif">
                                        @if($demande->status === 'pending')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg> 
                                            <span>pendant</span>
                                        @elseif($demande->status === 'expired')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>expiré</span>
                                        @elseif($demande->status === 'rejected')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>rejeté</span>
                                        @endif
                                    </span>
                                </td>

                                <!-- Start Date -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <div class="flex items-center dark:text-gray-400">
                                        {{ $demande->start_date ? \Carbon\Carbon::parse($demande->start_date)->format('M d, Y') : '—' }}
                                    </div>
                                </td>

                                <!-- End Date -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <div class="flex items-center dark:text-gray-400">
                                        {{ $demande->end_date ? \Carbon\Carbon::parse($demande->end_date)->format('M d, Y') : '—' }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    @if($demande->status)
                                        <div class="flex items-center space-x-2">
                                            <a href="{{route('showdemande', $demande->id)}}" 
                                               class="text-blue-600 hover:text-blue-800 transition-colors duration-150" 
                                               title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>
                                            
                                            @if($demande->status!='rejected')
                                                <a href="{{ route('editDemande', $demande->id) }}" 
                                                   class="text-green-600 hover:text-green-800 transition-colors duration-150" 
                                                   title="Edit Demande">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                                
                                                @if($demande->status != 'expired')
                                                    <button onclick="openApprovalModal({{ $demande->id }}, '{{ $demande->person->fullname ?? '' }}')" 
                                                            class="text-green-600 hover:text-green-800 transition-colors duration-150" 
                                                            title="Approve Demande">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                        </svg>
                                                    </button>
                                                    
                                                    <form action="{{ route('updateDemande', $demande->id) }}" method="POST" class="inline-block" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-800 transition-colors duration-150" 
                                                                title="Reject Demande"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette demande ?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- No Results Message -->
            <div id="no-results" class="hidden p-8 text-center dark:bg-gray-800">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-400">Aucune demande trouvée</h3>
                <p class="mt-1 text-sm text-gray-500">Essayez d'ajuster vos termes de recherche ou vos filtres.</p>
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
                                @if(isset($supervisors))
                                    @foreach($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
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

    <!-- JavaScript for Client-Side Search and Filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const typeFilter = document.getElementById('type-filter');
            const statusFilter = document.getElementById('status-filter');
            const sortSelect = document.getElementById('sort-select');
            const clearButton = document.getElementById('clear-search');
            const tableBody = document.getElementById('demandes-table-body');
            const searchStats = document.getElementById('search-stats');
            const searchTime = document.getElementById('search-time');
            const searchDuration = document.getElementById('search-duration');
            const noResults = document.getElementById('no-results');
            
            let allRows = Array.from(document.querySelectorAll('.demande-row'));
            let filteredRows = [...allRows];
            let searchTimer = null;

            // Real-time search functionality
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    performFiltering();
                }, 150);
            });

            // Filter functionality
            typeFilter.addEventListener('change', performFiltering);
            statusFilter.addEventListener('change', performFiltering);

            // Sort functionality
            sortSelect.addEventListener('change', function() {
                performSort();
            });

            // Clear search and filters
            clearButton.addEventListener('click', function() {
                clearAll();
            });

            // Perform filtering function
            function performFiltering() {
                const startTime = performance.now();
                const query = searchInput.value.toLowerCase().trim();
                const typeValue = typeFilter.value.toLowerCase();
                const statusValue = statusFilter.value.toLowerCase();
                
                filteredRows = allRows.filter(row => {
                    // Text search
                    let matchesSearch = true;
                    if (query !== '') {
                        const searchText = row.getAttribute('data-search-text');
                        matchesSearch = searchText.includes(query);
                    }
                    
                    // Type filter
                    let matchesType = true;
                    if (typeValue !== '') {
                        const rowType = row.getAttribute('data-type');
                        matchesType = rowType === typeValue;
                    }
                    
                    // Status filter
                    let matchesStatus = true;
                    if (statusValue !== '') {
                        const rowStatus = row.getAttribute('data-status');
                        matchesStatus = rowStatus === statusValue;
                    }
                    
                    return matchesSearch && matchesType && matchesStatus;
                });

                displayResults();
                highlightSearchTerms(query);
                
                const endTime = performance.now();
                const duration = Math.round(endTime - startTime);
                searchDuration.textContent = duration;
                
                if (query || typeValue || statusValue) {
                    searchTime.classList.remove('hidden');
                } else {
                    searchTime.classList.add('hidden');
                }
            }

            // Perform sort function
            function performSort() {
                const sortValue = sortSelect.value;
                
                filteredRows.sort((a, b) => {
                    switch(sortValue) {
                        case 'name-asc':
                            return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                        case 'name-desc':
                            return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
                        case 'date-newest':
                            return new Date(b.getAttribute('data-created')) - new Date(a.getAttribute('data-created'));
                        case 'date-oldest':
                            return new Date(a.getAttribute('data-created')) - new Date(b.getAttribute('data-created'));
                        case 'start-earliest':
                            const aStart = a.getAttribute('data-start-date');
                            const bStart = b.getAttribute('data-start-date');
                            if (!aStart && !bStart) return 0;
                            if (!aStart) return 1;
                            if (!bStart) return -1;
                            return new Date(aStart) - new Date(bStart);
                        case 'start-latest':
                            const aStartLate = a.getAttribute('data-start-date');
                            const bStartLate = b.getAttribute('data-start-date');
                            if (!aStartLate && !bStartLate) return 0;
                            if (!aStartLate) return 1;
                            if (!bStartLate) return -1;
                            return new Date(bStartLate) - new Date(aStartLate);
                        case 'status-priority':
                            const statusPriority = { 'pending': 1, 'expired': 2, 'rejected': 3 };
                            const aStatus = a.getAttribute('data-status');
                            const bStatus = b.getAttribute('data-status');
                            return (statusPriority[aStatus] || 4) - (statusPriority[bStatus] || 4);
                        default:
                            return 0;
                    }
                });
                
                displayResults();
            }

            // Display filtered and sorted results
            function displayResults() {
                // Hide all rows first
                allRows.forEach(row => row.style.display = 'none');
                
                if (filteredRows.length === 0) {
                    noResults.classList.remove('hidden');
                    searchStats.textContent = 'No demandes found';
                } else {
                    noResults.classList.add('hidden');
                    
                    // Show and reorder filtered rows
                    filteredRows.forEach((row, index) => {
                        row.style.display = 'table-row';
                        tableBody.appendChild(row); // This reorders the row
                    });
                    
                    const total = allRows.length;
                    searchStats.textContent = `Affichage de ${filteredRows.length}  personnes sur ${total} `;
                }
            }

            // Highlight search terms
            function highlightSearchTerms(query) {
                // Remove previous highlights
                allRows.forEach(row => {
                    const highlights = row.querySelectorAll('.name-highlight, .university-highlight, .diploma-highlight, .type-highlight');
                    highlights.forEach(element => {
                        element.innerHTML = element.textContent;
                    });
                });

                if (query) {
                    filteredRows.forEach(row => {
                        const highlights = row.querySelectorAll('.name-highlight, .university-highlight, .diploma-highlight, .type-highlight');
                        highlights.forEach(element => {
                            const text = element.textContent;
                            const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\                    // Status filter')})`, 'gi');
                            element.innerHTML = text.replace(regex, '<mark class="bg-yellow-200 px-1">$1</mark>');
                        });
                    });
                }
            }

            // Clear all filters and search
            function clearAll() {
                searchInput.value = '';
                typeFilter.value = '';
                statusFilter.value = '';
                sortSelect.value = 'name-asc';
                filteredRows = [...allRows];
                displayResults();
                highlightSearchTerms('');
                searchTime.classList.add('hidden');
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Focus search with Ctrl+F or Cmd+F
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    searchInput.focus();
                }
                
                // Clear search with Escape
                if (e.key === 'Escape' && document.activeElement === searchInput) {
                    clearAll();
                }
            });

            // Initialize
            performSort();
        });

        // Table header click sorting (alternative method)
        function sortTable(column) {
            const sortSelect = document.getElementById('sort-select');
            
            switch(column) {
                case 'name':
                    sortSelect.value = sortSelect.value === 'name-asc' ? 'name-desc' : 'name-asc';
                    break;
                case 'university':
                    sortSelect.value = sortSelect.value === 'name-asc' ? 'name-desc' : 'name-asc';
                    break;
                case 'status':
                    sortSelect.value = 'status-priority';
                    break;
                case 'start':
                    sortSelect.value = sortSelect.value === 'start-earliest' ? 'start-latest' : 'start-earliest';
                    break;
            }
            
            sortSelect.dispatchEvent(new Event('change'));
        }

        // Keep your existing modal functions
        function openApprovalModal(demandeId, fullname,) {
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

        // Enhanced event listeners for modal
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

        function setDateConstraints() {
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

    <style>
        /* Search highlighting */
        mark {
            border-radius: 2px;
        }
        
        /* Smooth transitions for row hiding/showing */
        .demande-row {
            transition: all 0.2s ease;
        }
        
        /* Loading state for search */
        .searching {
            opacity: 0.6;
            pointer-events: none;
        }
        
        /* Improved focus styles */
        #search-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Modal styles */
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
@endsection