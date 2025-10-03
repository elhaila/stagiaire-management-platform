@extends('layouts.layout')

@section('content')
<div class="p-4 sm:p-6 space-y-6 overflow-y-auto">

    {{-- Main Content Area --}}
    <header class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">gestion universitaire</h1>
    </header>   

    <div class="flex flex-col lg:flex-row gap-6">
        {{-- University List Card --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 lg:p-6 w-full lg:w-2/3 h-fit " style="padding: 0px">
            <div class="overflow-x-auto">

                {{-- 🔎 Search Input --}}
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <input type="text" placeholder="Recherche par nom ou ville..." id="searchInput"
                           class="w-full bg-gray-100 dark:bg-gray-700 border-transparent rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                </div>

                <table class="w-full text-left divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nom</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ville</th>
                        </tr>
                    </thead>
                    <tbody id="universityTable" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($universities as $university)
                            <tr>
                                <td class="px-4 py-2 text-xs text-gray-700">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                                                {{ substr($university->name ?? 'N', 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 name-highlight dark:text-white">
                                                {{ $university->name ?? '—' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $university->city ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-gray-500 dark:text-gray-400">Aucune université trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-4">
                {{ $universities->links() }}
            </div>
        </div>

        {{-- Add University Form --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 lg:p-6 w-full lg:w-1/3 h-fit">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Ajouter une université</h2>
            <form action="{{ route('storeUniversity') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">nom</label>
                    <input type="text" name="name" id="name"
                           class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ville</label>
                    <select name="city" id="city"
                            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        <option value="">-- sélectionner une ville --</option>
                        <option value="agadir">Agadir</option>
                        <option value="al Hoceima">Al Hoceima</option>
                        <option value="azrou">Azrou</option>
                        <option value="beni mellal">Beni Mellal</option>
                        <option value="berkane">Berkane</option>
                        <option value="casablanca">Casablanca</option>
                        <option value="chefchaouen">Chefchaouen</option>
                        <option value="dakhla">Dakhla</option>
                        <option value="el jadida">El Jadida</option>
                        <option value="errachidia">Errachidia</option>
                        <option value="essaouira">Essaouira</option>
                        <option value="fès">Fès</option>
                        <option value="guelmim">Guelmim</option>
                        <option value="ifrane">Ifrane</option>
                        <option value="kénitra">Kénitra</option>
                        <option value="khouribga">Khouribga</option>
                        <option value="laâyoune">Laâyoune</option>
                        <option value="larache">Larache</option>
                        <option value="marrakech">Marrakech</option>
                        <option value="meknès">Meknès</option>
                        <option value="mohammedia">Mohammedia</option>
                        <option value="nador">Nador</option>
                        <option value="ouarzazate">Ouarzazate</option>
                        <option value="oujda">Oujda</option>
                        <option value="rabat">Rabat</option>
                        <option value="safi">Safi</option>
                        <option value="salé">Salé</option>
                        <option value="settat">Settat</option>
                        <option value="tanger">Tanger</option>
                        <option value="taza">Taza</option>
                        <option value="tétouan">Tétouan</option>
                        <option value="tiznit">Tiznit</option>
                    </select>
                </div>

                <div>
                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Ajouter une université
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 🔎 JS Search Logic --}}
<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#universityTable tr");

        rows.forEach(row => {
            let name = row.cells[0]?.textContent.toLowerCase() || "";
            let city = row.cells[1]?.textContent.toLowerCase() || "";

            if (name.includes(filter) || city.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "rien";
            }
        });
    });
</script>
@endsection
