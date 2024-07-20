<x-layout>
    <x-slot:headings>
        Commune Urbaine page
    </x-slot:headings>
<div CLASS="flex justify-content-lg-between">

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
