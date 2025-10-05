@extends('layouts.layout')

@section('content')
    <div class="p-2 space-y-6 overflow-auto">
        <!-- Enhanced Search Section -->
        <div class="bg-white shadow rounded-lg p-4 mt-6 dark:bg-gray-800">
            <div class="flex flex-wrap gap-4 items-center">
                <!-- Real-time Search Input -->
                <div class="flex-1 min-w-[250px] relative">
                    <input type="text" 
                           id="search-input" 
                           placeholder="Rechercher par nom, CIN, courriel ou téléphone..." 
                           class="w-full border rounded px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-white dark:bg-gray-700 dark:border-transparent ">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Sort Options -->
                <select id="sort-select" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-800 dark:text-white">
                    <option value="name-asc">Name A-Z</option>
                    <option value="name-desc">Name Z-A</option>
                    <option value="date-newest">Le plus récent en premier</option>
                    <option value="date-oldest">Le plus ancien en premier</option>
                    <option value="demandes-most">Le plus de demandes</option>
                    <option value="demandes-least">Le moins de demandes</option>
                </select>

                <!-- Clear Search -->
                <button id="clear-search" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors duration-200">
                    Effacer
                </button>
            </div>
            
            <!-- Search Statistics -->
            <div class="mt-3 flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
                <span id="search-stats">Affichage de {{ $people->count() }} personnes sur {{ $people->count() }}</span>
            </div>
        </div>

        <h2 class="text-lg font-semibold mb-4 inline-block dark:text-white">Liste de personnes</h2>

        <!-- Results Container -->
        <div class="bg-white shadow rounded-lg overflow-hidden" style="font-size: small">
            <!-- TABLE VIEW (Desktop) -->
            <div class="overflow-x-auto hidden md:block">
                <table class="min-w-full w-full table-fixed divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700 dark:divide-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer dark:text-gray-400" 
                                onclick="sortTable('name')">
                                Nom complet 
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">CIN</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">TÉLÉPHONE</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer  dark:text-gray-400" 
                                onclick="sortTable('demandes')">
                                DEMANDES 
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer dark:text-gray-400" 
                                onclick="sortTable('date')">
                                Date d'inscription
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">ACTIONS</th>
                        </tr>
                    </thead>
                    
                    <tbody id="people-table-body" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach($people as $person)
                        <tr class="person-row transition-colors duration-150" 
                            data-name="{{ strtolower($person->fullname) }}" 
                            data-cin="{{ strtolower($person->cin) }}" 
                            data-email="{{ strtolower($person->email) }}" 
                            data-phone="{{ $person->phone }}" 
                            data-demandes="{{ $person->demandes->count() }}" 
                            data-date="{{ $person->created_at }}"
                            data-search-text="{{ strtolower($person->fullname . ' ' . $person->cin . ' ' . $person->email . ' ' . $person->phone) }}">
                            
                            <td class="px-4 py-2 whitespace-nowrap overflow-hidden text-ellipsis">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-sm font-medium">
                                            {{ substr($person->fullname, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-gray-900 name-highlight dark:text-gray-400" style="font-size: small">{{ $person->fullname }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap overflow-hidden text-ellipsis">
                                <span class="cin-highlight dark:text-gray-400">{{ $person->cin }}</span>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap overflow-hidden text-ellipsis">
                                <span class="email-highlight dark:text-gray-400">{{ $person->email }}</span>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap overflow-hidden text-ellipsis">
                                <span class="phone-highlight dark:text-gray-400">{{ $person->phone }}</span>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap overflow-hidden text-ellipsis">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $person->demandes->count() > 2 ? 'bg-green-100 text-green-800' : 
                                       ($person->demandes->count() > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ $person->demandes->count() }}
                                </span>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 overflow-hidden text-ellipsis">
                                {{ $person->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('showPerson', $person->id) }}" 
                                       class="text-blue-600 hover:text-blue-800 transition-colors duration-150" 
                                       title="View Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('editPerson', $person->id) }}" 
                                       class="text-green-600 hover:text-green-800 transition-colors duration-150" 
                                       title="Edit Person">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- CARD LIST (Mobile) -->
            <div id="people-cards-body" class="block md:hidden space-y-4 p-4 dark:bg-gray-900">
                @foreach($people as $person)
                    <div class="person-card bg-white dark:bg-gray-800 shadow rounded-lg p-4" 
                         data-name="{{ strtolower($person->fullname) }}" 
                         data-cin="{{ strtolower($person->cin) }}" 
                         data-email="{{ strtolower($person->email) }}" 
                         data-phone="{{ $person->phone }}" 
                         data-demandes="{{ $person->demandes->count() }}" 
                         data-date="{{ $person->created_at }}"
                         data-search-text="{{ strtolower($person->fullname . ' ' . $person->cin . ' ' . $person->email . ' ' . $person->phone) }}">
                        
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-200 name-highlight">{{ $person->fullname }}</h3>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $person->created_at->format('M d, Y') }}</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">CIN: <span class="cin-highlight">{{ $person->cin }}</span></p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 flex items-center mt-1">
                            <svg class="w-4 h-4 text-gray-400 mr-1 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <span class="email-highlight break-all">{{ $person->email }}</span>
                        </p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 flex items-center mt-1">
                            <svg class="w-4 h-4 text-gray-400 mr-1 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                            </svg>
                            <span class="phone-highlight">{{ $person->phone }}</span>
                        </p>
                        <p class="mt-2 text-xs">
                            <span class="px-2 py-1 rounded-full text-white text-xs 
                                {{ $person->demandes->count() > 2 ? 'bg-green-500' : 
                                   ($person->demandes->count() > 0 ? 'bg-blue-500' : 'bg-gray-400') }}">
                                {{ $person->demandes->count() }} demandes
                            </span>
                        </p>
                        <div class="mt-3 flex space-x-3">
                            <a href="{{ route('showPerson', $person->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir</a>
                            <a href="{{ route('editPerson', $person->id) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">Modifier</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results Message -->
            <div id="no-results" class="hidden p-8 text-center dark:bg-gray-800">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-400">Personne n'a trouvé</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-500">Essayez d'ajuster vos termes de recherche ou de supprimer la recherche.</p>
            </div>
        </div>
    </div>

    <!-- JavaScript for Client-Side Search -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const sortSelect = document.getElementById('sort-select');
            const clearButton = document.getElementById('clear-search');
            const tableBody = document.getElementById('people-table-body');
            const cardsBody = document.getElementById('people-cards-body');
            const searchStats = document.getElementById('search-stats');
            const noResults = document.getElementById('no-results');
            
            let allRows = Array.from(document.querySelectorAll('.person-row'));
            let allCards = Array.from(document.querySelectorAll('.person-card'));
            let filteredRows = [...allRows];
            let filteredCards = [...allCards];
            let searchTimer = null;

            // Real-time search functionality
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    performSearch();
                }, 150);
            });

            // Sort functionality
            sortSelect.addEventListener('change', function() {
                performSort();
            });

            // Clear search
            clearButton.addEventListener('click', function() {
                clearSearch();
            });

            // Perform search function
            function performSearch() {
                const query = searchInput.value.toLowerCase().trim();
                
                // Filter table rows
                filteredRows = allRows.filter(row => {
                    if (query === '') return true;
                    const searchText = row.getAttribute('data-search-text');
                    return searchText.includes(query);
                });

                // Filter cards
                filteredCards = allCards.filter(card => {
                    if (query === '') return true;
                    const searchText = card.getAttribute('data-search-text');
                    return searchText.includes(query);
                });

                displayResults();
                highlightSearchTerms(query);
            }

            // Perform sort function
            function performSort() {
                const sortValue = sortSelect.value;
                
                // Sort table rows
                filteredRows.sort((a, b) => {
                    return getSortComparison(a, b, sortValue);
                });

                // Sort cards
                filteredCards.sort((a, b) => {
                    return getSortComparison(a, b, sortValue);
                });
                
                displayResults();
            }

            // Get sort comparison
            function getSortComparison(a, b, sortValue) {
                switch(sortValue) {
                    case 'name-asc':
                        return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                    case 'name-desc':
                        return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
                    case 'date-newest':
                        return new Date(b.getAttribute('data-date')) - new Date(a.getAttribute('data-date'));
                    case 'date-oldest':
                        return new Date(a.getAttribute('data-date')) - new Date(b.getAttribute('data-date'));
                    case 'demandes-most':
                        return parseInt(b.getAttribute('data-demandes')) - parseInt(a.getAttribute('data-demandes'));
                    case 'demandes-least':
                        return parseInt(a.getAttribute('data-demandes')) - parseInt(b.getAttribute('data-demandes'));
                    default:
                        return 0;
                }
            }

            // Display filtered and sorted results
            function displayResults() {
                // Hide all rows and cards first
                allRows.forEach(row => row.style.display = 'none');
                allCards.forEach(card => card.style.display = 'none');
                
                if (filteredRows.length === 0 && filteredCards.length === 0) {
                    noResults.classList.remove('hidden');
                    searchStats.textContent = 'Aucune personne trouvée';
                } else {
                    noResults.classList.add('hidden');
                    
                    // Show and reorder filtered table rows
                    filteredRows.forEach((row) => {
                        row.style.display = 'table-row';
                        tableBody.appendChild(row);
                    });

                    // Show and reorder filtered cards
                    filteredCards.forEach((card) => {
                        card.style.display = 'block';
                        cardsBody.appendChild(card);
                    });
                    
                    const total = allRows.length;
                    const showing = filteredRows.length > 0 ? filteredRows.length : filteredCards.length;
                    searchStats.textContent = `Affichage de ${showing} personnes sur ${total}`;
                }
            }

            // Highlight search terms
            function highlightSearchTerms(query) {
                // Remove previous highlights from rows
                allRows.forEach(row => {
                    const highlights = row.querySelectorAll('.name-highlight, .cin-highlight, .email-highlight, .phone-highlight');
                    highlights.forEach(element => {
                        element.innerHTML = element.textContent;
                    });
                });

                // Remove previous highlights from cards
                allCards.forEach(card => {
                    const highlights = card.querySelectorAll('.name-highlight, .cin-highlight, .email-highlight, .phone-highlight');
                    highlights.forEach(element => {
                        element.innerHTML = element.textContent;
                    });
                });

                if (query) {
                    const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
                    
                    // Highlight in filtered rows
                    filteredRows.forEach(row => {
                        const highlights = row.querySelectorAll('.name-highlight, .cin-highlight, .email-highlight, .phone-highlight');
                        highlights.forEach(element => {
                            const text = element.textContent;
                            element.innerHTML = text.replace(regex, '<mark class="bg-yellow-200 dark:bg-yellow-600 px-1 rounded">$1</mark>');
                        });
                    });

                    // Highlight in filtered cards
                    filteredCards.forEach(card => {
                        const highlights = card.querySelectorAll('.name-highlight, .cin-highlight, .email-highlight, .phone-highlight');
                        highlights.forEach(element => {
                            const text = element.textContent;
                            element.innerHTML = text.replace(regex, '<mark class="bg-yellow-200 dark:bg-yellow-600 px-1 rounded">$1</mark>');
                        });
                    });
                }
            }

            // Clear search function
            function clearSearch() {
                searchInput.value = '';
                sortSelect.value = 'name-asc';
                filteredRows = [...allRows];
                filteredCards = [...allCards];
                displayResults();
                highlightSearchTerms('');
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    searchInput.focus();
                }
                
                if (e.key === 'Escape' && document.activeElement === searchInput) {
                    clearSearch();
                }
            });

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
                case 'demandes':
                    sortSelect.value = sortSelect.value === 'demandes-most' ? 'demandes-least' : 'demandes-most';
                    break;
                case 'date':
                    sortSelect.value = sortSelect.value === 'date-newest' ? 'date-oldest' : 'date-newest';
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
        
        /* Smooth transitions for row/card hiding/showing */
        .person-row, .person-card {
            transition: all 0.2s ease;
        }
        
        /* Improved focus styles */
        #search-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Custom scrollbar for better UX */
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
    </style>
@endsection