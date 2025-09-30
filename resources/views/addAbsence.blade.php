@extends('layouts.layout')
@section('content')
    <!-- Main Content -->
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 overflow-auto" style="padding-bottom: 100px">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Ajouter une nouvelle absence</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Enregistrer une absence pour un stagiaire avec des détails et une justification pertinents.</p>
            </div>

            <!-- Form Container -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                <form action="{{ route('StoreAbsence') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @csrf
                    
                    <!-- Absence Information Section -->
                    <div class="px-6 py-8 sm:px-8">
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                informations d'absence
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Sélectionnez le stagiaire et fournissez les détails de l’absence avec une justification appropriée.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Intern Selection -->
                            <div class="sm:col-span-2">
                                <label for="internship_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom du stagiaire <span class="text-red-500">*</span>
                                </label>
                                <select name="internship_id" id="internship_id" class="block w-full px-3 py-2 border {{ $errors->has('internship_id') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" required {{ isset($internship) ? 'readonly' : '' }}>
                                    @if(!isset($internship))
                                        <option value="">Sélectionnez un stagiaire</option>
                                    @endif
                                    @if(isset($internship))
                                        <!-- Single internship mode -->
                                        <option value="{{ $internship->id }}" selected>
                                            {{ $internship->demande->person->fullname ?? 'N/A' }} 
                                            ({{ $internship->demande->type ?? 'N/A' }} - {{ $internship->status ?? 'N/A' }})
                                        </option>
                                    @else
                                        <!-- Multiple internships mode -->
                                        @foreach ($internships as $internship)
                                            <option value="{{ $internship->id }}" {{ old('internship_id') == $internship->id ? 'selected' : '' }}>
                                                {{ $internship->demande->person->fullname ?? 'N/A' }} 
                                                ({{ $internship->demande->type ?? 'N/A' }} - {{ $internship->status ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('internship_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div class="sm:col-span-1">
                                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Date d'absence <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="block w-full px-3 py-2 border {{ $errors->has('date') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" required>
                                @error('date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="sm:col-span-1">
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    statut <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" class="block w-full px-3 py-2 border {{ $errors->has('status') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" required>
                                    <option value="">sélectionner le statut</option>
                                    <option value="justified" {{ old('status') == 'justified' ? 'selected' : '' }}>justifié</option>
                                    <option value="unjustified" {{ old('status') == 'unjustified' ? 'selected' : '' }}>injustifié</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Reason -->
                            <div class="sm:col-span-2" id="reason-container">
                                <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    raison <span class="text-red-500" id="reason-required">*</span>
                                </label>
                                <textarea name="reason" id="reason" rows="3" placeholder="Provide the reason for absence..." class="block w-full px-3 py-2 border {{ $errors->has('reason') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200 resize-none">{{ old('reason') }}</textarea>
                                @error('reason')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Justification File Upload -->
                            <div class="sm:col-span-2" id="justification-container">
                                <label for="justification" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    document de justification <span class="text-red-500" id="justification-required">*</span>
                                </label>
                                <div class="relative">
                                    <input type="file" name="justification" id="justification" accept=".pdf" class="block w-full px-3 py-2 border {{ $errors->has('justification') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-900 dark:file:text-green-300">
                                </div>
                                @error('justification')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" id="file-help">
                                    Télécharger un certificat médical, un document officiel ou une autre justification (PDF)
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 sm:px-8">
                        <div class="flex justify-end space-x-3">
                            <a href="" class="inline-flex items-center px-6 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                annuler
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Enregistrer l'absence
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for conditional form behavior -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const reasonTextarea = document.getElementById('reason');
            const justificationInput = document.getElementById('justification');
            const reasonContainer = document.getElementById('reason-container');
            const justificationContainer = document.getElementById('justification-container');
            const reasonRequired = document.getElementById('reason-required');
            const justificationRequired = document.getElementById('justification-required');
            const fileHelp = document.getElementById('file-help');

            function toggleFieldsBasedOnStatus() {
                const status = statusSelect.value;

                if (status === 'unjustified') {
                    // Disable and clear reason field
                    reasonTextarea.disabled = true;
                    reasonTextarea.value = '';
                    reasonTextarea.classList.add('bg-gray-100', 'dark:bg-gray-600', 'cursor-not-allowed');
                    reasonTextarea.classList.remove('focus:border-indigo-500', 'focus:ring-indigo-500');
                    reasonRequired.style.display = 'none';
                    
                    // Disable and clear justification field
                    justificationInput.disabled = true;
                    justificationInput.value = '';
                    justificationInput.classList.add('bg-gray-100', 'dark:bg-gray-600', 'cursor-not-allowed');
                    justificationInput.classList.remove('focus:border-indigo-500', 'focus:ring-indigo-500');
                    justificationRequired.style.display = 'none';
                    fileHelp.textContent = 'Not required for unjustified absences';
                    fileHelp.classList.add('text-gray-400');
                    
                    // Remove required attributes
                    reasonTextarea.removeAttribute('required');
                    justificationInput.removeAttribute('required');

                } else if (status === 'justified') {
                    // Enable reason field
                    reasonTextarea.disabled = false;
                    reasonTextarea.classList.remove('bg-gray-100', 'dark:bg-gray-600', 'cursor-not-allowed');
                    reasonTextarea.classList.add('focus:border-indigo-500', 'focus:ring-indigo-500');
                    reasonRequired.style.display = 'inline';
                    
                    // Enable justification field
                    justificationInput.disabled = false;
                    justificationInput.classList.remove('bg-gray-100', 'dark:bg-gray-600', 'cursor-not-allowed');
                    justificationInput.classList.add('focus:border-indigo-500', 'focus:ring-indigo-500');
                    justificationRequired.style.display = 'inline';
                    fileHelp.textContent = 'Upload medical certificate, official document, or other justification (PDF)';
                    fileHelp.classList.remove('text-gray-400');
                    
                    // Add required attributes
                    reasonTextarea.setAttribute('required', 'required');
                    justificationInput.setAttribute('required', 'required');

                } else {
                    // Default state - enable all fields but don't require them yet
                    reasonTextarea.disabled = false;
                    reasonTextarea.classList.remove('bg-gray-100', 'dark:bg-gray-600', 'cursor-not-allowed');
                    reasonTextarea.classList.add('focus:border-indigo-500', 'focus:ring-indigo-500');
                    
                    justificationInput.disabled = false;
                    justificationInput.classList.remove('bg-gray-100', 'dark:bg-gray-600', 'cursor-not-allowed');
                    justificationInput.classList.add('focus:border-indigo-500', 'focus:ring-indigo-500');
                    
                    reasonRequired.style.display = 'inline';
                    justificationRequired.style.display = 'inline';
                    fileHelp.textContent = 'Upload medical certificate, official document, or other justification (PDF)';
                    fileHelp.classList.remove('text-gray-400');
                }
            }

            // Initialize on page load
            toggleFieldsBasedOnStatus();

            // Listen for changes to the status field
            statusSelect.addEventListener('change', toggleFieldsBasedOnStatus);
        });
    </script>
@endsection