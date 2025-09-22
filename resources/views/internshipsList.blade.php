@extends('layouts.layout')
@section('content')
    <div class="p-6 space-y-6 overflow-auto">
        <!-- Enhanced Search Section -->
        <div class="bg-white shadow rounded-lg p-4 mt-6">
            <div class="flex flex-wrap gap-4 items-center">
                <!-- Real-time Search Input -->
                <div class="flex-1 min-w-[250px] relative">
                    <input type="text" 
                           id="search-input" 
                           placeholder="Search by name, supervisor, type..." 
                           class="w-full border rounded px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Type Filter -->
                <select id="type-filter" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="pfe">PFE</option>
                    <option value="stage">Stage</option>
                </select>

                <!-- Status Filter -->
                <select id="status-filter" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="finished">Finished</option>
                    <option value="terminated">Terminated</option>
                </select>

                <!-- Sort Options -->
                <select id="sort-select" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="name-asc">Name A-Z</option>
                    <option value="name-desc">Name Z-A</option>
                    <option value="date-newest">Newest First</option>
                    <option value="date-oldest">Oldest First</option>
                    <option value="start-earliest">Start Date (Earliest)</option>
                    <option value="start-latest">Start Date (Latest)</option>
                    <option value="end-earliest">End Date (Earliest)</option>
                    <option value="end-latest">End Date (Latest)</option>
                    <option value="status-priority" selected>Status Priority</option>
                </select>

                <!-- Clear Search -->
                <button id="clear-search" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors duration-200">
                    Clear
                </button>
            </div>
            
            <!-- Search Statistics -->
            <div class="mt-3 flex items-center justify-between text-sm text-gray-600">
                <span id="search-stats">Showing {{ $Internships->count() }} of {{ $Internships->count() }} interns</span>
                {{-- <span id="search-time" class="hidden">Search completed in <span id="search-duration">0</span>ms</span> --}}
            </div>
        </div>

        <h2 class="text-lg font-semibold mb-4 inline-block">Interns List</h2>

        <!-- Results Container -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="internships-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100" 
                                onclick="sortTable('name')">
                                Full Name
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100"
                                onclick="sortTable('supervisor')">
                                Supervisor
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100"
                                onclick="sortTable('status')">
                                Status
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100"
                                onclick="sortTable('start')">
                                Start Date
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100"
                                onclick="sortTable('end')">
                                End Date
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody id="internships-table-body" class="bg-white divide-y divide-gray-200">
                        @foreach ($Internships as $Internship)
                            <tr class="internship-row hover:bg-gray-50 transition-colors duration-150" 
                                data-internship-id="{{ $Internship->id }}"
                                data-name="{{ strtolower($Internship->demande->person->fullname ?? '') }}" 
                                data-supervisor="{{ strtolower($Internship->user->name ?? '') }}" 
                                data-type="{{ strtolower($Internship->demande->type ?? '') }}" 
                                data-status="{{ strtolower($Internship->status ?? '') }}"
                                data-start-date="{{ $Internship->start_date ?? '' }}"
                                data-end-date="{{ $Internship->end_date ?? '' }}"
                                data-created="{{ $Internship->created_at }}"
                                data-search-text="{{ strtolower(($Internship->demande->person->fullname ?? '') . ' ' . ($Internship->user->name ?? '') . ' ' . ($Internship->demande->type ?? '')) }}">
                                
                                <!-- Person -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-sm font-medium">
                                                {{ substr($Internship->demande->person->fullname ?? 'N', 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 name-highlight">
                                                {{ $Internship->demande->person->fullname ?? '—' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $Internship->demande->diplome->name ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Supervisor -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <div class="flex items-center">
                                        @if($Internship->user)
                                            <div class="flex-shrink-0 h-6 w-6">
                                                <div class="h-6 w-6 rounded-full bg-green-500 flex items-center justify-center text-white text-xs font-medium">
                                                    {{ substr($Internship->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-2">
                                                <span class="supervisor-highlight">{{ $Internship->user->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400">No supervisor</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Type -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ strtolower($Internship->demande->type ?? '') === 'pfe' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        <span class="type-highlight">{{ ucfirst($Internship->demande->type ?? '') }}</span>
                                    </span>
                                </td>

                                <!-- Status (with badge style) -->
                                <td class="px-4 py-2">
                                    <span class="inline-flex items-center px-2 py-1 text-xs rounded-full font-medium
                                        @if($Internship->status === 'active') bg-green-100 text-green-800
                                        @elseif($Internship->status === 'pending') bg-yellow-200 text-yellow-800
                                        @elseif($Internship->status === 'finished') bg-red-100 text-red-800
                                        @elseif($Internship->status === 'terminated') bg-gray-100 text-gray-800
                                        @endif">
                                        @if($Internship->status === 'active')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        @elseif($Internship->status === 'pending')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                        @elseif($Internship->status === 'finished')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        @elseif($Internship->status === 'terminated')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                        {{ ucfirst($Internship->status ?? '') }}
                                    </span>
                                </td>

                                <!-- Start Date -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <div class="flex items-center">
                                        {{ $Internship->start_date ? \Carbon\Carbon::parse($Internship->start_date)->format('M d, Y') : '—' }}
                                    </div>
                                </td>

                                <!-- End Date -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <div class="flex items-center">
                                        {{ $Internship->end_date ? \Carbon\Carbon::parse($Internship->end_date)->format('M d, Y') : '—' }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{route('showIntern', $Internship->id)}}" 
                                           class="text-blue-600 hover:text-blue-800 transition-colors duration-150" 
                                           title="View Details">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        @if($Internship->status=='finished')                                    
                                            <button class="text-green-600 hover:text-green-800 transition-colors duration-150 edit-btn" 
                                                    title="Edit Dates" 
                                                    data-internship-id="{{ $Internship->id }}"
                                                    data-fiche-date="{{ $Internship->date_fiche_fin_stage }}"
                                                    data-rapport-date="{{ $Internship->date_depot_rapport_stage }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Inline Edit Form Row (Hidden by default) -->
                            <tr class="edit-form-row hidden" id="edit-form-{{ $Internship->id }}">
                                <td colspan="7" class="px-4 py-4 bg-gray-50 border-l-4 border-indigo-500">
                                    <form action="{{ route('internships.updateDates', $Internship->id) }}" method="POST" class="inline-edit-form">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="bg-white rounded-lg p-4 shadow-sm border">
                                            <div class="mb-3">
                                                <h4 class="text-sm font-medium text-gray-900 mb-2 flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    Update Internship Completion Dates
                                                </h4>
                                                <p class="text-xs text-gray-500">Update the final stage form and report submission dates</p>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <!-- Date Fiche Fin Stage -->
                                                <div>
                                                    <label for="date_fiche_fin_stage_{{ $Internship->id }}" class="block text-xs font-medium text-gray-700 mb-1">
                                                        Final Stage Form Date
                                                    </label>
                                                    <input type="date" 
                                                           name="date_fiche_fin_stage" 
                                                           id="date_fiche_fin_stage_{{ $Internship->id }}"
                                                           value="{{ $Internship->date_fiche_fin_stage }}"
                                                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                </div>

                                                <!-- Date Depot Rapport Stage -->
                                                <div>
                                                    <label for="date_depot_rapport_stage_{{ $Internship->id }}" class="block text-xs font-medium text-gray-700 mb-1">
                                                        Report Submission Date
                                                    </label>
                                                    <input type="date" 
                                                           name="date_depot_rapport_stage" 
                                                           id="date_depot_rapport_stage_{{ $Internship->id }}"
                                                           value="{{ $Internship->date_depot_rapport_stage }}"
                                                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                </div>
                                            </div>

                                            <div class="flex justify-end space-x-2">
                                                <button type="button" class="cancel-edit-btn px-3 py-1 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                                                    <svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Cancel
                                                </button>
                                                <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                                                    <svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Update Dates
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- No Results Message -->
            <div id="no-results" class="hidden p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No internships found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search terms or filters.</p>
            </div>
        </div>

        <!-- Pagination (hide when searching) -->
        <div id="pagination-container" class="mt-4">
            {{ $Internships->links() }}
        </div>
    </div>

    <!-- JavaScript for Client-Side Search and Inline Editing -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search elements
            const searchInput = document.getElementById('search-input');
            const typeFilter = document.getElementById('type-filter');
            const statusFilter = document.getElementById('status-filter');
            const sortSelect = document.getElementById('sort-select');
            const clearButton = document.getElementById('clear-search');
            const tableBody = document.getElementById('internships-table-body');
            const searchStats = document.getElementById('search-stats');
            const searchTime = document.getElementById('search-time');
            const searchDuration = document.getElementById('search-duration');
            const noResults = document.getElementById('no-results');
            const paginationContainer = document.getElementById('pagination-container');
            
            // Edit elements
            const editButtons = document.querySelectorAll('.edit-btn');
            const cancelButtons = document.querySelectorAll('.cancel-edit-btn');
            
            let allRows = Array.from(document.querySelectorAll('.internship-row'));
            let filteredRows = [...allRows];
            let searchTimer = null;

            // Search and filter functionality
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    performFiltering();
                }, 150);
            });

            typeFilter.addEventListener('change', performFiltering);
            statusFilter.addEventListener('change', performFiltering);
            sortSelect.addEventListener('change', performSort);
            clearButton.addEventListener('click', clearAll);

            // Inline editing functionality
            editButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const internshipId = this.getAttribute('data-internship-id');
                    const ficheDate = this.getAttribute('data-fiche-date');
                    const rapportDate = this.getAttribute('data-rapport-date');
                    
                    // Hide all other edit forms first
                    hideAllEditForms();
                    
                    // Show the specific edit form
                    const editForm = document.getElementById('edit-form-' + internshipId);
                    if (editForm) {
                        editForm.classList.remove('hidden');
                        editForm.style.display = 'table-row';
                        
                        // Populate form fields
                        const ficheInput = document.getElementById('date_fiche_fin_stage_' + internshipId);
                        const rapportInput = document.getElementById('date_depot_rapport_stage_' + internshipId);
                        
                        if (ficheInput) {
                            ficheInput.value = ficheDate || '';
                        }
                        if (rapportInput) {
                            rapportInput.value = rapportDate || '';
                        }
                        
                        // Focus on first input
                        if (ficheInput) {
                            setTimeout(() => ficheInput.focus(), 100);
                        }
                    }
                });
            });

            cancelButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const editForm = this.closest('.edit-form-row');
                    if (editForm) {
                        editForm.classList.add('hidden');
                    }
                });
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
                    paginationContainer.style.display = 'none';
                } else {
                    searchTime.classList.add('hidden');
                    paginationContainer.style.display = 'block';
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
                        case 'end-earliest':
                            const aEnd = a.getAttribute('data-end-date');
                            const bEnd = b.getAttribute('data-end-date');
                            if (!aEnd && !bEnd) return 0;
                            if (!aEnd) return 1;
                            if (!bEnd) return -1;
                            return new Date(aEnd) - new Date(bEnd);
                        case 'end-latest':
                            const aEndLate = a.getAttribute('data-end-date');
                            const bEndLate = b.getAttribute('data-end-date');
                            if (!aEndLate && !bEndLate) return 0;
                            if (!aEndLate) return 1;
                            if (!bEndLate) return -1;
                            return new Date(bEndLate) - new Date(aEndLate);
                        case 'status-priority':
                            const statusPriority = { 'active': 1, 'pending': 2, 'finished': 3, 'terminated': 4 };
                            const aStatus = a.getAttribute('data-status');
                            const bStatus = b.getAttribute('data-status');
                            return (statusPriority[aStatus] || 5) - (statusPriority[bStatus] || 5);
                        default:
                            return 0;
                    }
                });
                
                displayResults();
            }

            // Display filtered and sorted results
            function displayResults() {
                // Hide all rows first
                allRows.forEach(row => {
                    row.style.display = 'none';
                });
                
                // Hide all edit forms
                document.querySelectorAll('.edit-form-row').forEach(form => {
                    form.style.display = 'none';
                });
                
                if (filteredRows.length === 0) {
                    noResults.classList.remove('hidden');
                    searchStats.textContent = 'No internships found';
                } else {
                    noResults.classList.add('hidden');
                    
                    // Show and reorder filtered rows
                    filteredRows.forEach((row, index) => {
                        row.style.display = 'table-row';
                        tableBody.appendChild(row);
                        
                        // Handle edit form - make sure it appears after its row
                        const internshipId = row.getAttribute('data-internship-id');
                        const editForm = document.getElementById('edit-form-' + internshipId);
                        if (editForm) {
                            // Only show the edit form if it's not hidden
                            if (!editForm.classList.contains('hidden')) {
                                editForm.style.display = 'table-row';
                            }
                            // Insert edit form after its corresponding row
                            if (row.nextSibling !== editForm) {
                                row.parentNode.insertBefore(editForm, row.nextSibling);
                            }
                        }
                    });
                    
                    const total = allRows.length;
                    searchStats.textContent = `Showing ${filteredRows.length} of ${total} internships`;
                }
            }

            // Highlight search terms
            function highlightSearchTerms(query) {
                // Remove previous highlights
                allRows.forEach(row => {
                    const highlights = row.querySelectorAll('.name-highlight, .supervisor-highlight, .type-highlight');
                    highlights.forEach(element => {
                        element.innerHTML = element.textContent;
                    });
                });

                if (query) {
                    filteredRows.forEach(row => {
                        const highlights = row.querySelectorAll('.name-highlight, .supervisor-highlight, .type-highlight');
                        highlights.forEach(element => {
                            const text = element.textContent;
                            const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\                    hideAllEditForms();')})`, 'gi');
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
                paginationContainer.style.display = 'block';
                hideAllEditForms();
            }

            // Hide all edit forms
            function hideAllEditForms() {
                const editForms = document.querySelectorAll('.edit-form-row');
                editForms.forEach(form => {
                    form.classList.add('hidden');
                    form.style.display = 'none';
                });
            }

            // Handle clicks outside to hide edit forms
            document.addEventListener('click', function(event) {
                const isEditButton = event.target.closest('.edit-btn');
                const isEditForm = event.target.closest('.edit-form-row');
                
                if (!isEditButton && !isEditForm) {
                    hideAllEditForms();
                }
            });

            // Handle form submissions with AJAX
            const editForms = document.querySelectorAll('.inline-edit-form');
            editForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const actionUrl = this.getAttribute('action');
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.innerHTML;
                    
                    // Show loading state
                    submitButton.innerHTML = '<svg class="w-3 h-3 mr-1 inline animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Updating...';
                    submitButton.disabled = true;
                    
                    fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('.edit-form-row').classList.add('hidden');
                            showNotification('Dates updated successfully!', 'success');
                        } else {
                            showNotification('Error updating dates: ' + (data.message || 'Unknown error'), 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred while updating the dates.', 'error');
                    })
                    .finally(() => {
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                    });
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    searchInput.focus();
                }
                
                if (e.key === 'Escape' && document.activeElement === searchInput) {
                    clearAll();
                }
            });

            // Simple notification function
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transition-all duration-300 ${
                    type === 'success' ? 'bg-green-500' : 
                    type === 'error' ? 'bg-red-500' : 
                    'bg-blue-500'
                }`;
                notification.textContent = message;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }

            // Initialize
            performSort();
        });

        // Table header click sorting
        function sortTable(column) {
            const sortSelect = document.getElementById('sort-select');
            
            switch(column) {
                case 'name':
                    sortSelect.value = sortSelect.value === 'name-asc' ? 'name-desc' : 'name-asc';
                    break;
                case 'supervisor':
                    sortSelect.value = sortSelect.value === 'name-asc' ? 'name-desc' : 'name-asc';
                    break;
                case 'status':
                    sortSelect.value = 'status-priority';
                    break;
                case 'start':
                    sortSelect.value = sortSelect.value === 'start-earliest' ? 'start-latest' : 'start-earliest';
                    break;
                case 'end':
                    sortSelect.value = sortSelect.value === 'end-earliest' ? 'end-latest' : 'end-earliest';
                    break;
            }
            
            sortSelect.dispatchEvent(new Event('change'));
        }
    </script>

    <style>
        /* Search highlighting */
        mark {
            border-radius: 2px;
        }
        
        /* Smooth transitions */
        .internship-row {
            transition: all 0.2s ease;
        }
        
        .edit-form-row {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            animation: slideDown 0.3s ease-out;
        }
        
        .edit-form-row:not(.hidden) {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .edit-form-row.hidden {
            display: none;
        }
        
        /* Loading state */
        .searching {
            opacity: 0.6;
            pointer-events: none;
        }
        
        /* Focus styles */
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

        /* Avatar improvements */
        .rounded-full {
            transition: transform 0.2s ease;
        }

        .rounded-full:hover {
            transform: scale(1.1);
        }

        /* Button hover effects */
        button:hover {
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }
    </style>
@endsection