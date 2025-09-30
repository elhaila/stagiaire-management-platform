@extends('layouts.layout')

@section('content')
<div class="p-4 sm:p-6 space-y-6 overflow-y-auto">

    {{-- Main Form Card --}}
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        
        {{-- Card Header --}}
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Modifier les informations personnelles de <span class="text-indigo-600 dark:text-indigo-400">{{ $internship->demande->person->fullname }}</span></h1>
            </div>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('internship.update', $internship->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">
                {{-- Responsive Grid for Form Fields --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Full Name --}}
                    <div>
                        <label for="fullname" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                        <input type="text" name="fullname" id="fullname" value="{{ old('fullname', $internship->demande->person->fullname) }}"
                            readonly class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300">
                    </div>

                    {{-- Supervisor --}}
                    <div>
                        <label for="supervisor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">superviseur</label>
                        <select name="supervisor" id="supervisor" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('supervisor', $internship->user->id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Project name --}}
                    <div>
                        <label for="Project_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">nom du projet</label>
                        <input type="text" name="Project_name" id="Project_name" value="{{ old('Project_name', $internship->project_name) }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300">
                    </div>

                    {{-- Start Date --}}
                    <div class="sm:col-span-1">
                        <label for="start" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            date de début <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="start" id="start" value="{{ $internship->start_date }}" class="block w-full px-3 py-2 border {{ $errors->has('start') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" required>
                        @error('start')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- End Date -->
                    <div class="sm:col-span-1">
                        <label for="end" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            date de fin <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="end" id="end" value="{{ $internship->end_date }}" class="block w-full px-3 py-2 border {{ $errors->has('end') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" required>
                        @error('end')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- End-of-Internship Form --}}
                    <div class="sm:col-span-1">
                        <label for="date_fiche_fin_stage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fichier de stage de date de fin
                        </label>
                        <input type="date" name="date_fiche_fin_stage" id="date_fiche_fin_stage" value="{{ $internship->date_fiche_fin_stage }}" class="block w-full px-3 py-2 border {{ $errors->has('date_fiche_fin_stage') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" >
                        @error('date_fiche_fin_stage')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Date Internship Report -->
                    <div class="sm:col-span-1">
                        <label for="date_depot_rapport" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            rapport de stage
                        </label>
                        <input type="date" name="date_depot_rapport" id="date_depot_rapport" value="{{ $internship->date_depot_rapport_stage }}" class="block w-full px-3 py-2 border {{ $errors->has('date_depot_rapport') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" >
                        @error('date_depot_rapport')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="flex justify-end items-center p-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 rounded-b-lg space-x-4">
                <a href="{{route('showIntern', $internship->id)}}" 
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 font-semibold text-sm transition duration-300">
                   annuler
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-semibold text-sm transition duration-300">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    mettre à jour les changements
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
