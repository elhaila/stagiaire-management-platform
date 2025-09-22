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
                           placeholder="Search by intern name, supervisor, reason..." 
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
                    <option value="justified">Justified</option>
                    <option value="unjustified">Unjustified</option>
                </select>

                <!-- Date Range Filter -->
                <select id="date-filter" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Dates</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="last-month">Last Month</option>
                </select>

                <!-- Sort Options -->
                <select id="sort-select" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="date-newest">Date (Newest)</option>
                    <option value="date-oldest">Date (Oldest)</option>
                    <option value="name-asc">Intern A-Z</option>
                    <option value="name-desc">Intern Z-A</option>
                    <option value="status-priority">Status Priority</option>
                </select>

                <!-- Clear Search -->
                <button id="clear-search" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors duration-200">
                    Clear
                </button>
            </div>
            
            <!-- Search Statistics -->
            <div class="mt-3 flex items-center justify-between text-sm text-gray-600">
                <span id="search-stats">Showing {{ $absences->count() }} of {{ $absences->count() }} absences</span>
                {{-- <span id="search-time" class="hidden">Search completed in <span id="search-duration">0</span>ms</span> --}}
            </div>
        </div>

        <!-- Results Container -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100" 
                                onclick="sortTable('intern')">
                                Intern
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
                                onclick="sortTable('date')">
                                Date
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100"
                                onclick="sortTable('status')">
                                Status
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Justification</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody id="absences-table-body" class="bg-white divide-y divide-gray-200">
                        @forelse ($absences as $absence)
                            <tr class="absence-row hover:bg-gray-50 transition-colors duration-150" 
                                data-intern="{{ strtolower($absence->internship->demande->person->fullname ?? '') }}" 
                                data-supervisor="{{ strtolower($absence->internship->user->name ?? '') }}" 
                                data-type="{{ strtolower($absence->internship->demande->type ?? '') }}" 
                                data-status="{{ strtolower($absence->status ?? '') }}"
                                data-date="{{ $absence->date ?? '' }}"
                                data-reason="{{ strtolower($absence->reason ?? '') }}"
                                data-created="{{ $absence->created_at }}"
                                data-search-text="{{ strtolower(($absence->internship->demande->person->fullname ?? '') . ' ' . ($absence->internship->user->name ?? '') . ' ' . ($absence->reason ?? '') . ' ' . ($absence->internship->demande->type ?? '')) }}">
                                
                                <!-- Intern -->
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center text-white text-sm font-medium">
                                                {{ substr($absence->internship->demande->person->fullname ?? 'N', 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 intern-highlight">
                                                {{ $absence->internship->demande->person->fullname ?? '—' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $absence->internship->demande->diplome->name ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Supervisor -->
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <div class="flex items-center">
                                        @if($absence->internship->user)
                                            <div class="flex-shrink-0 h-6 w-6">
                                                <div class="h-6 w-6 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-medium">
                                                    {{ substr($absence->internship->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-2">
                                                <span class="supervisor-highlight">{{ $absence->internship->user->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400">No supervisor</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Type -->
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ strtolower($absence->internship->demande->type ?? '') === 'pfe' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        <span class="type-highlight">{{ ucfirst($absence->internship->demande->type ?? '—') }}</span>
                                    </span>
                                </td>

                                <!-- Date -->
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($absence->date)->format('l') }}</div>
                                            <div class="font-medium">{{ \Carbon\Carbon::parse($absence->date)->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-2">
                                    <span class="inline-flex items-center px-2 py-1 text-xs rounded-full font-medium
                                        @if($absence->status === 'justified') bg-green-100 text-green-800
                                        @elseif($absence->status === 'unjustified') bg-red-100 text-red-800
                                        @endif">
                                        @if($absence->status === 'justified')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                        {{ ucfirst($absence->status) }}
                                    </span>
                                </td>

                                <!-- Reason -->
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    @if($absence->status === 'justified' && $absence->reason)
                                        <div class="max-w-xs">
                                            <p class="reason-highlight text-sm truncate" title="{{ $absence->reason }}">
                                                {{ $absence->reason }}
                                            </p>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">No reason provided</span>
                                    @endif
                                </td>

                                <!-- Justification -->
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    @if($absence->status === 'justified' && $absence->justification)
                                        <a href="{{ Storage::url($absence->justification) }}" target="_blank"
                                           class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors duration-150">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span class="text-xs">View Document</span>
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">No document</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <div class="flex items-center space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800 transition-colors duration-150" 
                                                title="View Details"
                                                onclick="viewAbsenceDetails({{ $absence->id }}, '{{ $absence->internship->demande->person->fullname ?? '' }}', '{{ $absence->date }}', '{{ $absence->status }}', '{{ addslashes($absence->reason ?? '') }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </button>
                                        
                                        {{-- <button class="text-green-600 hover:text-green-800 transition-colors duration-150" 
                                                title="Edit Absence"
                                                onclick="editAbsence({{ $absence->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button> --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    No absences found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- No Results Message -->
            <div id="no-results" class="hidden p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No absences found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search terms or filters.</p>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">Absence Details</h3>
                    <button onclick="closeDetailsModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div id="modal-content" class="space-y-4">
                    <!-- Content will be populated by JavaScript -->
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button onclick="closeDetailsModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-200">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Client-Side Search and Filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search and filter elements
            const searchInput = document.getElementById('search-input');
            const typeFilter = document.getElementById('type-filter');
            const statusFilter = document.getElementById('status-filter');
            const dateFilter = document.getElementById('date-filter');
            const sortSelect = document.getElementById('sort-select');
            const clearButton = document.getElementById('clear-search');
            const tableBody = document.getElementById('absences-table-body');
            const searchStats = document.getElementById('search-stats');
            const searchTime = document.getElementById('search-time');
            const searchDuration = document.getElementById('search-duration');
            const noResults = document.getElementById('no-results');
            
            let allRows = Array.from(document.querySelectorAll('.absence-row'));
            let filteredRows = [...allRows];
            let searchTimer = null;

            // Event listeners
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    performFiltering();
                }, 150);
            });

            typeFilter.addEventListener('change', performFiltering);
            statusFilter.addEventListener('change', performFiltering);
            dateFilter.addEventListener('change', performFiltering);
            sortSelect.addEventListener('change', performSort);
            clearButton.addEventListener('click', clearAll);

            // Perform filtering function
            function performFiltering() {
                const startTime = performance.now();
                const query = searchInput.value.toLowerCase().trim();
                const typeValue = typeFilter.value.toLowerCase();
                const statusValue = statusFilter.value.toLowerCase();
                const dateValue = dateFilter.value;
                
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
                    
                    // Date filter
                    let matchesDate = true;
                    if (dateValue !== '') {
                        const rowDate = new Date(row.getAttribute('data-date'));
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);
                        
                        switch(dateValue) {
                            case 'today':
                                const todayStr = today.toISOString().split('T')[0];
                                matchesDate = row.getAttribute('data-date') === todayStr;
                                break;
                            case 'week':
                                const weekStart = new Date(today);
                                weekStart.setDate(today.getDate() - today.getDay());
                                matchesDate = rowDate >= weekStart && rowDate <= today;
                                break;
                            case 'month':
                                const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
                                matchesDate = rowDate >= monthStart && rowDate <= today;
                                break;
                            case 'last-month':
                                const lastMonthStart = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                                const lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);
                                matchesDate = rowDate >= lastMonthStart && rowDate <= lastMonthEnd;
                                break;
                        }
                    }
                    
                    return matchesSearch && matchesType && matchesStatus && matchesDate;
                });

                displayResults();
                highlightSearchTerms(query);
                
                const endTime = performance.now();
                const duration = Math.round(endTime - startTime);
                searchDuration.textContent = duration;
                
                if (query || typeValue || statusValue || dateValue) {
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
                        case 'date-newest':
                            return new Date(b.getAttribute('data-date')) - new Date(a.getAttribute('data-date'));
                        case 'date-oldest':
                            return new Date(a.getAttribute('data-date')) - new Date(b.getAttribute('data-date'));
                        case 'name-asc':
                            return a.getAttribute('data-intern').localeCompare(b.getAttribute('data-intern'));
                        case 'name-desc':
                            return b.getAttribute('data-intern').localeCompare(a.getAttribute('data-intern'));
                        case 'status-priority':
                            const statusPriority = { 'unjustified': 1, 'justified': 2 };
                            const aStatus = a.getAttribute('data-status');
                            const bStatus = b.getAttribute('data-status');
                            return (statusPriority[aStatus] || 3) - (statusPriority[bStatus] || 3);
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
                    searchStats.textContent = 'No absences found';
                } else {
                    noResults.classList.add('hidden');
                    
                    // Show and reorder filtered rows
                    filteredRows.forEach(row => {
                        row.style.display = 'table-row';
                        tableBody.appendChild(row);
                    });
                    
                    const total = allRows.length;
                    searchStats.textContent = `Showing ${filteredRows.length} of ${total} absences`;
                }
            }

            // Highlight search terms
            function highlightSearchTerms(query) {
                // Remove previous highlights
                allRows.forEach(row => {
                    const highlights = row.querySelectorAll('.intern-highlight, .supervisor-highlight, .reason-highlight, .type-highlight');
                    highlights.forEach(element => {
                        element.innerHTML = element.textContent;
                    });
                });

                if (query) {
                    filteredRows.forEach(row => {
                        const highlights = row.querySelectorAll('.intern-highlight, .supervisor-highlight, .reason-highlight, .type-highlight');
                        highlights.forEach(element => {
                            const text = element.textContent;
                            const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\                                const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);')})`, 'gi');
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
                dateFilter.value = '';
                sortSelect.value = 'date-newest';
                filteredRows = [...allRows];
                displayResults();
                highlightSearchTerms('');
                searchTime.classList.add('hidden');
            }

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

            // Initialize
            performSort();
        });

        // Table header click sorting
        function sortTable(column) {
            const sortSelect = document.getElementById('sort-select');
            
            switch(column) {
                case 'intern':
                    sortSelect.value = sortSelect.value === 'name-asc' ? 'name-desc' : 'name-asc';
                    break;
                case 'supervisor':
                    sortSelect.value = sortSelect.value === 'name-asc' ? 'name-desc' : 'name-asc';
                    break;
                case 'date':
                    sortSelect.value = sortSelect.value === 'date-newest' ? 'date-oldest' : 'date-newest';
                    break;
                case 'status':
                    sortSelect.value = 'status-priority';
                    break;
            }
            
            sortSelect.dispatchEvent(new Event('change'));
        }

        // Modal functions for absence details
        function viewAbsenceDetails(id, internName, date, status, reason) {
            const modal = document.getElementById('detailsModal');
            const modalContent = document.getElementById('modalContent');
            const content = document.getElementById('modal-content');
            
            // Populate modal content
            content.innerHTML = `
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Intern Name</label>
                        <p class="mt-1 text-sm text-gray-900">${internName}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <p class="mt-1 text-sm text-gray-900">${new Date(date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${status === 'justified' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${status.charAt(0).toUpperCase() + status.slice(1)}
                        </span>
                    </div>
                    ${reason ? `
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Reason</label>
                            <p class="mt-1 text-sm text-gray-900">${reason}</p>
                        </div>
                    ` : ''}
                </div>
            `;
            
            // Show modal
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.add('modal-enter');
                modalContent.classList.remove('scale-95', 'opacity-0');
            }, 10);
        }

        function closeDetailsModal() {
            const modal = document.getElementById('detailsModal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.classList.remove('modal-enter');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 150);
        }

        // function editAbsence(id) {
        //     // Redirect to edit page or open edit modal
        //     window.location.href = `/absences/${id}/edit`;
        // }

        // Close modal when clicking backdrop
        document.getElementById('detailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailsModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('detailsModal').classList.contains('hidden')) {
                closeDetailsModal();
            }
        });
    </script>

    <style>
        /* Search highlighting */
        mark {
            border-radius: 2px;
        }
        
        /* Smooth transitions */
        .absence-row {
            transition: all 0.2s ease;
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

        /* Modal styles */
        .modal-enter {
            opacity: 1;
            transform: scale(1);
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

        /* Truncate text in reason column */
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endsection
                