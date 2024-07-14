<x-layout>
    <x-slot:headings>
        Commune Urbaine page
    </x-slot:headings>
<div CLASS="flex justify-content-lg-between">
{{--
    <div class="relative inline-block text-left">
        <div>
            <button type="button" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" id="menu-button" aria-expanded="false" aria-haspopup="true">
                Options
                <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden transition ease-out duration-100" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            <div class="py-1" role="none">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-0">Edit</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-1">Duplicate</a>
            </div>
            <div class="py-1" role="none">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-2">Archive</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-3">Move</a>
            </div>
            <div class="py-1" role="none">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">Share</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-5">Add to favorites</a>
            </div>
            <div class="py-1" role="none">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-6">Delete</a>
            </div>
        </div>
    </div>
--}}

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Selectionner la commune urbaine
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
            @foreach($CUS  as $cu)
                <li><a class="dropdown-item" href="/Cu/{{ $cu['cu_name'] }}">{{$cu->cu_name}}</a></li>
            @endforeach
        </ul>
    </div>



</div>
</x-layout>
