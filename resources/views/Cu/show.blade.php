<x-layout>
    <x-slot name="headings">
        La Commune Urbaine : {{$nomCom->cu_name}}
    </x-slot>

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Selectionner la commune urbaine
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
            @if ($regisseurs->isNotEmpty())
                @foreach($regisseurs as $regisseur)
                    <li><a class="dropdown-item" href="/Cu/{{ $nomCom->cu_name }}/{{$regisseur->name}}">{{$regisseur->name}}</a></li>
                @endforeach
            @else
                <p>No regisseurs found for this CU.</p>
            @endif
        </ul>
    </div>


</x-layout>
