<x-layout>
    <x-slot name="headings">
        Tableau de Commune Urbaine Par

    <div class="relative inline-block text-left ">
        <div>
            <x-button   id="menu-button" type="button" class="font-bold text-black-900 ">
                Mois
                <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
            </x-button>
        </div>
        <div class="absolute left-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" id="dropdown-menu">
            <div class="py-1" role="none">
                @foreach($months as $month)
                    <a href="/Cu/{cu_name}/{name}/{{ $month }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-{{ $loop->index }}">{{ ucfirst($month) }}</a>
                @endforeach

            </div>
        </div>
    </div>
    </x-slot>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const menuButton = document.getElementById('menu-button');
            const dropdownMenu = document.getElementById('dropdown-menu');

            menuButton.addEventListener('click', () => {
                dropdownMenu.classList.toggle('hidden');
            });

            window.addEventListener('click', (e) => {
                if (!menuButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        });
    </script>
</x-layout>
