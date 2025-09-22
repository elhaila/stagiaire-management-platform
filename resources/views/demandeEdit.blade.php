@extends('layouts.layout')
@section('content')
    <!-- Main Content -->
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 overflow-auto" style="padding-bottom: 100px">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Update <span class="text-blue-800">{{ $demande->person->fullname }}</span> Demande</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Fill out the form below to update the internship demand.</p>
            </div>
            <!-- Form Container -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                <form action="{{ route('updateDemande', $demande->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')                    
                    <!-- Personal Information Section --> 
                    <div class="px-6 py-8 sm:px-8">
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Personal Information
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Basic information about the applicant and their academic background.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Full Name -->
                            <div class="sm:col-span-1">
                                <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                    <select name="full_name" id="full_name" class="block w-full px-3 py-2 border {{ $errors->has('full_name') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" required>
                                        <option value="{{ $demande->person->id }}" {{ old('full_name') == $demande->person->id ? 'selected' : '' }}>{{ $demande->person->fullname }}</option>
                                    </select>
                                @error('full_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- University -->
                            <div class="sm:col-span-1">
                                <label for="university" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    University <span class="text-red-500">*</span>
                                </label>
                                <select name="university" id="university" class="block w-full px-3 py-2 border {{ $errors->has('university') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" required>
                                    <option value="">Select a university</option>
                                    @foreach ($university as $uni)
                                        <option value="{{ $uni->id }}" {{ $demande->university->id == $uni->id ? 'selected' : '' }}>{{ $uni->name }}</option>
                                    @endforeach
                                </select>
                                @error('university')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Diploma -->
                            <div class="sm:col-span-1">
                                <label for="diploma" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Diploma <span class="text-red-500">*</span>
                                </label>
                                <select name="diploma" id="diploma" class="block w-full px-3 py-2 border {{ $errors->has('diploma') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" required>
                                    <option value="">Select a diploma</option>
                                    @foreach ($diplome as $dip)
                                        <option value="{{ $dip->id }}" {{ $demande->diplome->id == $dip->id ? 'selected' : '' }}>{{ $dip->name }}</option>
                                    @endforeach
                                </select>
                                @error('diploma')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="sm:col-span-1">
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Type of Internship <span class="text-red-500">*</span>
                                </label>
                                <select name="type" id="type" class="block w-full px-3 py-2 border {{ $errors->has('type') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" required>
                                    <option value="">Select a type</option>
                                    <option value="PFE" {{ $demande->type == 'PFE' ? 'selected' : '' }}>PFE</option>
                                    <option value="Stage" {{ $demande->type == 'Stage' ? 'selected' : '' }}>Stage</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div class="sm:col-span-1">
                                <label for="start" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Start Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="start" id="start" value="{{ $demande->start_date }}" class="block w-full px-3 py-2 border {{ $errors->has('start') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" required>
                                @error('start')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div class="sm:col-span-1">
                                <label for="end" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    End Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="end" id="end" value="{{ $demande->end_date }}" class="block w-full px-3 py-2 border {{ $errors->has('end') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200" required>
                                @error('end')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CV Upload -->
                            <div class="sm:col-span-1">
                                <label for="cv" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    CV Upload <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="file" name="cv" id="cv" accept=".pdf" class="block w-full px-3 py-2 border {{ $errors->has('cv') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300">
                                </div>
                                @error('cv')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PDF files only</p>
                            </div>
                            @if($demande->cv)
                                <div class="mt-3 flex items-center space-x-4">
                                    <a href="{{ Storage::url($demande->cv) }}" target="_blank"
                                       class="inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        View Current CV
                                    </a>
                                </div>
                            @endif


                            <!-- Description -->
                            <div class="sm:col-span-2">
                                <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Description
                                </label>
                                <textarea name="note" id="note" rows="4" placeholder="Additional notes or description about the internship request..." class="block w-full px-3 py-2 border {{ $errors->has('note') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200 resize-none">{{ old('note') }}</textarea>
                                @error('note')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden Status Field -->
                        <input type="hidden" name="status" value="pending">
                    </div>

                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 sm:px-8">
                        <div class="flex justify-end space-x-3">
                            <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Demande
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection