<x-layout>
    <x-slot name="headings">
        <div class="flex ">
        La Commune Urbaine : <p class="text-blue-500 ">{{$nomCom->cu_name}}</p>
        </div>
    </x-slot>

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Selectionner la commune urbaine
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
            @if ($regisseurs->isNotEmpty())
                @foreach($regisseurs as $regisseur)
                    <li><a class="dropdown-item" href="/Regisseur/{{$regisseur->id}}">{{$regisseur->name}}</a></li>
                @endforeach
            @else
                <p>No regisseurs found for this CU.</p>
            @endif
        </ul>
    </div>


</x-layout>
