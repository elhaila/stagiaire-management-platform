@extends('layouts.layout')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 overflow-auto">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
        
        {{-- Header --}}
        <header class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Gestion de diplôme</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Un endroit central pour ajouter, modifier et supprimer tous les diplômes.
            </p>
        </header>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Column: Diploma List --}}
            <main class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                    {{-- Search and Filter Bar --}}
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <input type="text" placeholder="Search by name or city" id="searchInput"
                               class="w-full bg-gray-100 dark:bg-gray-700 border-transparent rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                    </div>

                    {{-- Diploma Table --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nome</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($diplomas as $diploma)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-200">
                                        <td class="px-4 py-2 text-xs text-gray-700">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                                                        {{ substr($diploma->name ?? 'N', 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900 name-highlight">
                                                        {{ $diploma->name ?? '—' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                                            <a href="#" class="edit-btn font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors"
                                                data-id="{{ $diploma->id }}"
                                                data-name="{{ $diploma->name }}">
                                                modifier
                                            </a>
                                            <form action="{{ route('deleteDiplom',$diploma->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this diploma?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-semibold text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400 transition-colors">
                                                    supprimer
                                                </button>
                                            </form>
                                            <!-- Inline Edit Form Row (Hidden by default) -->
                                            <tr class="edit-form-row hidden" id="edit-form-{{ $diploma->id }}">
                                                <td colspan="7" class="px-4 py-4 bg-gray-50 border-l-4 border-indigo-500">
                                                    <form action="{{route('updateDiploma',$diploma->id)}}" method="POST" class="inline-edit-form">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="bg-white rounded-lg p-4 shadow-sm border">
                                                            <div class="mb-3">
                                                                <h4 class="text-sm font-medium text-gray-900 mb-2 flex items-center">
                                                                    <svg class="w-4 h-4 mr-2 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                                                                    </svg>
                                                                    Mettre à jour le nom du diplôme
                                                                </h4>
                                                            </div>

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                                    <div>
                                                                    <label for="name" class="block text-xs font-medium text-gray-700 mb-1">
                                                                        Nome
                                                                    </label>
                                                                    <input type="text" 
                                                                        name="name" 
                                                                        id="name"
                                                                        value="{{$diploma->name}}"
                                                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                                </div>
                                                            </div>

                                                            <div class="flex justify-end space-x-2">
                                                                <button id="cancel-edit" type="button" class="cancel-edit-btn px-3 py-1 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                                                                    <svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                    </svg>
                                                                    annuler
                                                                </button>
                                                                <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                                                                    <svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                    Mettre à jour le nom
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Links --}}
                    @if ($diplomas->hasPages())
                        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                            {{ $diplomas->links() }}
                        </div>
                    @endif
                </div>
            </main>


            <aside class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 sticky top-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                            Ajouter un nouveau diplôme
                        </h2>
                    </div>
                    {{-- Add Form --}}
                    <form action="{{ route('storeDiploma') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom du diplôme</label>
                            <input type="text" name="name" style="border: 1px solid #9c9c9c;!important" class="editInput mt-1 block w-full dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-4 py-2" required>
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                                Ajouter un diplôme
                            </button>
                        </div>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const diplomaId = this.dataset.id;
            const diplomaName = this.dataset.name;

            // Find the right edit form row for this diploma
            const formRow = document.getElementById(`edit-form-${diplomaId}`);
            const inputField = formRow.querySelector('input[name="name"]');

            // Fill input
            inputField.value = diplomaName;

            // Hide any open forms first
            document.querySelectorAll('.edit-form-row').forEach(row => row.classList.add('hidden'));

            // Show only this one
            formRow.classList.remove('hidden');
        });
    });

    // Cancel button (works for each form)
    document.querySelectorAll('.cancel-edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const formRow = this.closest('.edit-form-row');
            formRow.classList.add('hidden');
        });
    });

    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase().trim();

        // Loop through all diploma rows (only the main rows, not edit forms)
        document.querySelectorAll('tbody tr').forEach(row => {
            const nameCell = row.querySelector('td:first-child'); // first cell has the name

            // Skip edit form rows
            if (row.classList.contains('edit-form-row')) return;

            if (nameCell) {
                const text = nameCell.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });


</script>


@endsection
